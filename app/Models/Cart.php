<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

/**
 * Cart
 *
 * Creates a cart instance
 */
class Cart
{
    private $items = [];
    private $ref_no = null;
    private $totalQty = 0;
    private $totalCartQty = 0;
    private $subTotal = 0;
    private $seniorDiscount = 0;
    private $otherDiscount = null;
    private $otherDiscountRate = 0;
    private $deliveryFee = 0;
    private $total_vat_able = 0;
    private $total_vat_amount = 0;
    private $total_vat_exempt = 0;
    private $totalPrice = 0;
    private $sc_image = null;
    private $rx_image = null;
    private $is_SC = false;
    private $has_RX = false;
    private $claim_type = null;
    private $date = null;
    private $final_price = 0;

    public function __construct($oldCart) {

        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->ref_no = $oldCart->ref_no;
            $this->totalQty = $oldCart->totalQty;
            $this->subTotal = $oldCart->subTotal;
            $this->seniorDiscount = $oldCart->seniorDiscount;
            $this->otherDiscount = $oldCart->otherDiscount;
            $this->deliveryFee = $oldCart->deliveryFee;
            $this->totalPrice = $oldCart->totalPrice;
            $this->sc_image = $oldCart->sc_image;
            $this->rx_image = $oldCart->rx_image;
            $this->is_SC = $oldCart->is_SC;
            $this->has_RX = $oldCart->has_RX;
            $this->claim_type = $oldCart->claim_type;
            $this->total_vat_able = $oldCart->total_vat_able;
            $this->total_vat_amount = $oldCart->total_vat_amount;
            $this->total_vat_exempt = $oldCart->total_vat_exempt;
            $this->date = $oldCart->date;
            $this->final_price = $oldCart->final_price;
        } else {
            $this->ref_no = uniqid();
        }
    }

    // ADD ITEM TO CART
    public function add($item, $id, $quantity, $rx)
    {

        $price = 0;
        if ($item->sale()->exists()) {
            if ($item->sale->is_percent == true) {
                $price = round(($item->price - ($item->price * ($item->sale->rate / 100))), 2);
            }
            else
            {
                $price = $item->price - $item->sale->rate;
            }
        }
        else {
            $price = $item->price;
        }

        $storedItem = ['qty' => 0, 'price' => $price, 'item' => $item, 'rx' => $rx];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['rx'] = $rx;
        $storedItem['qty'] += $quantity;
        $storedItem['price'] = $price;

        $this->items[$id] = $storedItem;
    }

    // REMOVE ITEM FROM CART
    public function remove($id)
    {
        unset($this->items[$id]);
    }

    // INCREASE QUANTITY
    public function increase($id)
    {
        $storedItem = $this->items[$id];

        $storedItem['qty'] += 1;

        $this->totalQty += $storedItem['qty'];

        $this->totalPrice += $storedItem['item']->price;

        $this->items[$id] = $storedItem;

    }

    // DECREASE QUANTITY
    public function decrease($id)
    {
        if (isset($this->items[$id])) {
            $storedItem = $this->items[$id];

        $storedItem['qty'] -= 1;

        $this->totalQty -= 1;

        $this->totalPrice -= $storedItem['item']->price;

        $this->items[$id] = $storedItem;

        if ($storedItem['qty'] <= 0) {
            $this->remove($id);
        }

        if (empty($this->items)) {
            return true;
        }

        return false;
        }

        if (empty($this->items)) {
            return true;
        }
    }

    // FINALIZE ORDER
    public function finalize()
    {
        $this->calculate();
        $this->final_price();
        $this->date = now();

    }

    // CHECK IF ORDER NEEDS PRESCRIPTION
    public function check_RX()
    {
        foreach ($this->items as $item) {
            if ($item['rx'] == 1) {
                return true;
            }
        }
    }

    // CALCULATE SUBTOTAL
    public function calculate_subtotal()
    {
        $this->subTotal = 0;

        foreach ($this->items as $item) {
            // FIND IF PRODUCT EXIST
            $product = Product::find($item['item']['id']);
            if ($product == null) {
                return redirect()->route('cart')->with('message', 'error cart product not found, clear your cart and try again');
            }

            $price = 0;

            if ($product->sale()->exists()) {
                if ($product->sale->is_percent == true) {
                    $price = $product->price - ($product->price * ($product->sale->rate / 100));
                }
                else {
                    $price = $product->price - $product->sale->rate;
                }
            }
            else{
                $price = $product->price;
            }

            $this->totalQty += 1;
            $this->totalCartQty += $item['qty'];
            $this->subTotal += $price * $item['qty'];
        }
    }

    // CALCULATE ALL
    public function calculate()
    {
        // RESET TOTALS
        $this->totalQty = 0;
        $this->totalCartQty = 0;
        $this->total_vat_able = 0;
        $this->total_vat_amount = 0;
        $this->total_vat_exempt = 0;

        $this->calculate_subtotal();

        // CALCULATE EACH ITEM
        foreach ($this->items as $item) {
            // FIND IF PRODUCT EXIST
            $product = Product::find($item['item']['id']);
            if ($product == null) {
                return redirect()->route('cart')->with('message', 'error cart product not found, clear your cart and try again');
            }

            // UPDATE CART COUNT
            $this->calculate_subtotal();

            // IF SENIOR SET TAX TO VAT EXEMPT
            if($this->is_SC == true) {
                if ($product->sale()->exists()) {
                    if ($product->sale->is_percent == true) {
                        $this->total_vat_exempt += (round(($product->price - ($product->price * ($product->sale->rate / 100))), 2) * $item['qty']);
                    }
                    else
                    {
                        $this->total_vat_exempt += ($product->price - $product->sale->rate) * $item['qty'];
                    }
                }
                else {
                    $this->total_vat_exempt += $product->price * $item['qty'];
                }

            }

            // IF REGULAR CALCULATE VAT
            if($this->is_SC == false) {
                $tax_rate = $product->tax->rate;

                // CHECK FOR SALE
                $price = $product->price;
                if ($product->sale()->exists()) {
                    if ($product->sale->is_percent == true) {
                        $price = $product->price - ($product->price * ($product->sale->rate / 100));
                    }
                    else {
                        $price = $product->price - $product->sale->rate;
                    }
                }

                // IF VAT IS ZERO
                if ($tax_rate == 0) {
                    $this->total_vat_exempt += $price * $item['qty'];
                }
                else{
                    $this->total_vat_able += $price * $item['qty'];
                }
            }
        }

        // COMPUTE TOTAL VAT
        $this->total_vat_amount = ($this->total_vat_able * 0.12) / (1 + 0.12);
        $this->total_vat_able -= $this->total_vat_amount;
        $vatExemption = ($this->total_vat_exempt * 0.12) / (1 + 0.12);
        $this->total_vat_exempt -= $vatExemption;

        $this->total_vat_exempt = round($this->total_vat_exempt, 2);
        $this->total_vat_amount = round($this->total_vat_amount, 2);
        $this->total_vat_able = round($this->total_vat_able, 2);

        $this->totalPrice = $this->total_vat_able + $this->total_vat_amount + $this->total_vat_exempt ;
    }

    /**
     * Get the value of items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get the value of totalQty
     */
    public function getTotalQty()
    {
        $this->totalQty = 0;
        foreach ($this->items as $item) {
            $this->totalQty += 1;
        }
        return $this->totalQty;
    }

    /**
     * Get the value of totalCartQty
     */
    public function getTotalCartQty()
    {
        $this->totalCartQty = 0;
        foreach ($this->items as $item) {
            $this->totalCartQty += $item['qty'];
        }
        return $this->totalCartQty;
    }

    /**
     * Get the value of subTotal
     */
    public function getSubTotal()
    {
        $this->calculate_subtotal();
        return $this->subTotal;
    }

    /**
     * Get the value of seniorDiscount
     */
    public function getSeniorDiscount()
    {
        return $this->seniorDiscount;
    }

    /**
     * Set the value of seniorDiscount
     *
     * @return  self
     */
    public function setSeniorDiscount($seniorDiscount)
    {
        $this->seniorDiscount = round($seniorDiscount, 2);

        return $this;
    }

    /**
     * Get the value of otherDiscount
     */
    public function getOtherDiscount()
    {
        return $this->otherDiscount;
    }

    /**
     * Set the value of otherDiscount
     *
     * @return  self
     */
    public function setOtherDiscount($otherDiscount)
    {
        $this->otherDiscount = $otherDiscount;

        return $this;
    }

    /**
     * Get the value of otherDiscountRate
     */
    public function getOtherDiscountRate()
    {
        return $this->otherDiscountRate;
    }

    /**
     * Set the value of otherDiscountRate
     *
     * @return  self
     */
    public function setOtherDiscountRate($otherDiscountRate)
    {
        $this->otherDiscountRate = $otherDiscountRate;

        return $this;
    }

    /**
     * Get the value of deliveryFee
     */
    public function getDeliveryFee()
    {
        return $this->deliveryFee;
    }

    /**
     * Set the value of deliveryFee
     *
     * @return  self
     */
    public function setDeliveryFee($deliveryFee)
    {
        $this->deliveryFee = $deliveryFee;

        return $this;
    }

    /**
     * Get the value of total_vat_able
     */
    public function getTotal_vat_able()
    {
        return $this->total_vat_able;
    }

    /**
     * Set the value of total_vat_able
     *
     * @return  self
     */
    public function setTotal_vat_able($total_vat_able)
    {
        $this->total_vat_able = $total_vat_able;

        return $this;
    }

    /**
     * Get the value of total_vat_amount
     */
    public function getTotal_vat_amount()
    {
        return $this->total_vat_amount;
    }

    /**
     * Set the value of total_vat_amount
     *
     * @return  self
     */
    public function setTotal_vat_amount($total_vat_amount)
    {
        $this->total_vat_amount = $total_vat_amount;

        return $this;
    }

    /**
     * Get the value of total_vat_exempt
     */
    public function getTotal_vat_exempt()
    {
        return $this->total_vat_exempt;
    }

    /**
     * Set the value of total_vat_exempt
     *
     * @return  self
     */
    public function setTotal_vat_exempt($total_vat_exempt)
    {
        $this->total_vat_exempt = $total_vat_exempt;

        return $this;
    }

    /**
     * Get the value of totalPrice
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set the value of totalPrice
     *
     * @return  self
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get the value of sc_image
     */
    public function getSc_image()
    {
        return $this->sc_image;
    }

    /**
     * Set the value of sc_image
     *
     * @return  self
     */
    public function setSc_image($sc_image)
    {
        $this->sc_image = $sc_image;

        return $this;
    }

    /**
     * Get the value of rx_image
     */
    public function getRx_image()
    {
        return $this->rx_image;
    }

    /**
     * Set the value of rx_image
     *
     * @return  self
     */
    public function setRx_image($rx_image)
    {
        $this->rx_image = $rx_image;

        return $this;
    }

    /**
     * Get the value of is_SC
     */
    public function getIs_SC()
    {
        return $this->is_SC;
    }

    /**
     * Set the value of is_SC
     *
     * @return  self
     */
    public function setIs_SC($is_SC)
    {
        $this->is_SC = $is_SC;

        return $this;
    }

    /**
     * Get the value of claim_type
     */
    public function getClaim_type()
    {
        return $this->claim_type;
    }

    /**
     * Set the value of claim_type
     *
     * @return  self
     */
    public function setClaim_type($claim_type)
    {
        $this->claim_type = $claim_type;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        $this->setDate(now());
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function final_price()
    {
        // CALCULATE
        $this->final_price = 0;
        $sc_discount = 0;
        $other_discount = 0;
        $fee = 0;
        $this->calculate();
        $price = $this->totalPrice;

        // SENIOR DISCOUNT
        if($this->getIs_SC()){
            $this->setSeniorDiscount($price * 0.2);
            $sc_discount = $this->getSeniorDiscount();
        }

        // OTHER DISCOUNT
        if($this->getOtherDiscount() != null){
            $other_discount = $price / $this->getOtherDiscountRate();
        }

        // DELIVERY FEE
        if ($this->getClaim_type() == 'delivery') {
            $fee = $this->getDeliveryFee();
        }

        $this->final_price = $price - $sc_discount - $other_discount + $fee;
        return $this->final_price;
    }


    /**
     * Get the value of has_RX
     */
    public function getHas_RX()
    {
        return $this->has_RX;
    }

    /**
     * Set the value of has_RX
     *
     * @return  self
     */
    public function setHas_RX($has_RX)
    {
        $this->has_RX = $has_RX;

        return $this;
    }

    /**
     * Get the value of ref_no
     */
    public function getRef_no()
    {
        return $this->ref_no;
    }
}

<?php

namespace App\Models;


/**
 * Cart
 *
 * Creates a cart instance
 */
class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalCartQty = 0;
    public $subTotal = 0;
    public $seniorDiscount = 0;
    public $otherDiscount = 0;
    public $deliveryFee = 30;
    public $total_vat_able = 0;
    public $total_vat_amount = 0;
    public $total_vat_exempt = 0;
    public $totalPrice = 0;
    public $sc_image = '';
    public $rx_image = '';
    public $is_SC = false;
    public $has_RX = false;
    public $is_delivery = false;
    public $is_pickup = false;
    public $date = '';

    public function __construct($oldCart) {

        if ($oldCart) {
            $this->items = $oldCart->items;
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
            $this->is_delivery = $oldCart->is_delivery;
            $this->is_pickup = $oldCart->is_pickup;
            $this->total_vat_able = $oldCart->total_vat_able;
            $this->total_vat_amount = $oldCart->total_vat_amount;
            $this->total_vat_exempt = $oldCart->total_vat_exempt;
        }
    }

    public function setRxImage($name)
    {
        $this->rx_image = $name;
    }

    public function getRxImage()
    {
        return $this->rx_image;
    }

    public function setSCImage($name)
    {
        $this->sc_image = $name;
    }

    public function getSCImage()
    {
        return $this->sc_image;
    }

    public function check_RX()
    {
        foreach ($this->items as $item) {
            if ($item['rx'] == 1) {
                return true;
            }
        }
    }

    public function recalculate()
    {
        $this->totalQty = 0;
        $this->totalCartQty = 0;
        $this->subTotal = 0;

        foreach ($this->items as $item) {
            $this->totalQty += 1;
            $this->totalCartQty += $item['qty'];
            $this->subTotal += $item['price'] * $item['qty'];
        }

    }

    public function add($item, $id, $quantity, $rx)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item, 'rx' => $rx];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['rx'] = $rx;
        $storedItem['qty'] += $quantity;
        $storedItem['price'] = $item->price;
        $this->items[$id] = $storedItem;

        $this->recalculate();
    }

    public function remove($id, $quantity)
    {
        unset($this->items[$id]);
        $this->totalQty -= $quantity;

        $this->recalculate();
    }

    public function increase($id)
    {
        $storedItem = $this->items[$id];

        $storedItem['qty'] += 1;

        $this->totalQty = $storedItem['qty'];

        $this->totalPrice += $storedItem['item']->price;

        $this->items[$id] = $storedItem;

        $this->recalculate();
    }

    public function decrease($id)
    {
        $storedItem = $this->items[$id];

        $storedItem['qty'] -= 1;

        if ($storedItem['qty'] <= 0) {

            unset($this->items[$id]);

            if (count($this->items) <= 0) {
                return false;
            }

            return true;
        }

        $this->totalQty = $storedItem['qty'];

        $this->totalPrice += $storedItem['item']->price;

        $this->items[$id] = $storedItem;

        $this->recalculate();

        return true;
    }

    public function getTotalCartQty()
    {
        $this->recalculate();

        return $this->totalCartQty;
    }

    public function getSubTotal()
    {
        $this->recalculate();

        return $this->subTotal;
    }


    public function getDiscount()
    {
        return $this->otherDiscount;
    }

    public function getDelivery()
    {
        return $this->deliveryFee;
    }

    public function setSC()
    {
        $total = $this->getTotal();
        $discount = $total * 0.20;
        $scDiscount = $total - $discount;
        $this->totalPrice -= $discount;
    }

    public function getTotal()
    {
        $this->totalPrice = 0;
        $this->recalculate();

        $this->totalPrice = $this->total_vat_amount + $this->total_vat_exempt + $this->total_vat_able;

        if ($this->seniorDiscount) {
            $this->setSC();
        }

        if ($this->is_delivery == true && $this->is_pickup == false) {
            $this->totalPrice += $this->deliveryFee;
        }

        return $this->totalPrice;
    }

    public function setToDelivery()
    {
        $this->is_delivery = true;
        $this->is_pickup = false;
        $this->recalculate();
    }

    public function setToPickup()
    {
        $this->is_delivery = false;
        $this->is_pickup = true;
        $this->recalculate();
    }

    public function calculate_regular()
    {
        if ($this->is_SC == true) {
            return redirect()->route('cart')->with('message', 'calution does not match customer status');
        }

        $products = null;
        $this->total_vat_amount = 0;
        $this->total_vat_able = 0;
        $this->total_vat_exempt = 0;
        $vatAmount = 0;
        $vatAble = 0;
        $vatExempt = 0;

        foreach ($this->items as $item) {

            $products[$item['item']['id']] = Product::find($item['item']['id']);
            if ($products[$item['item']['id']] == null) {
                return redirect()->route('cart')->with('message', 'error cart product not found, clear your cart and try again');
            }
            $tax_rate = $products[$item['item']['id']]->tax->rate;
            if ($tax_rate == 0) {
                $exempt = $products[$item['item']['id']]->price * $item['qty'];
                $vatExempt += $exempt;
            }
            else{
                $vatAmount  += (($products[$item['item']['id']]->price * $item['qty']) * $tax_rate) / (1 + $tax_rate);
                $vatAble += ($products[$item['item']['id']]->price * $item['qty']) - $vatAmount;


            }
        }

        $this->total_vat_exempt = round($vatExempt, 2);
        $this->total_vat_amount = round($vatAmount, 2);
        $this->total_vat_able = round($vatAble, 2);

        $this->recalculate();
    }

    public function calculate_senior()
    {
        if ($this->is_SC == false) {
            return redirect()->route('cart')->with('message', 'calution does not match customer status');
        }

        $products = null;
        $this->total_vat_exempt = 0;
        $vatExempt = 0;

        foreach ($this->items as $item) {
            $products[$item['item']['id']] = Product::find($item['item']['id']);

            if ($products[$item['item']['id']] == null) {
                return redirect()->route('cart')->with('message', 'error cart product not found, clear your cart and try again');
            }

            $exempt = $products[$item['item']['id']]->price * $item['qty'];
            $vatExempt += $exempt;
        }

        $this->total_vat_exempt = round($vatExempt, 2);
        $this->recalculate();
    }

    public function finalize()
    {
        $this->recalculate();

        if ($this->is_SC == true) {
            $this->calculate_senior();
        }

        if ($this->is_SC == false) {
            $this->calculate_regular();
        }

        $this->date = now();

        $this->getTotal();
    }
}

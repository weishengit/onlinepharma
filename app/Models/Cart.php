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
    public $seniorDiscount = 0.20;
    public $otherDiscount = 0;
    public $deliveryFee = 30;
    public $totalPrice = 0;
    public $sc_image = '';
    public $rx_image = '';
    public $is_SC = false;
    public $has_RX = false;

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
        $this->totalPrice = 0;
        foreach ($this->items as $item) {
            $this->totalQty += 1;
            $this->totalCartQty += $item['qty'];
            $this->subTotal += $item['price'] * $item['qty'];
            $this->totalPrice += $item['price'] * $item['qty'];
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

    public function getSC()
    {
        $subTotal = $this->getSubTotal();
        $discount = $subTotal * 0.20;

        $scDiscount = $subTotal - $discount;

        return $scDiscount;
    }

    public function getTotal()
    {
        $this->recalculate();
        return $this->totalPrice;
    }
}

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
    public $vatTax = 0.12;
    public $deliveryFee = 30;
    public $totalPrice = 0;

    public function __construct($oldCart) {
        
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->subTotal = $oldCart->subTotal;
            $this->seniorDiscount = $oldCart->seniorDiscount;
            $this->otherDiscount = $oldCart->otherDiscount;
            $this->vatTax = $oldCart->vatTax;
            $this->deliveryFee = $oldCart->deliveryFee;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id, $quantity)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty'] += $quantity;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty += $quantity;
        $this->totalPrice += $item->price;
    }

    public function remove($id, $quantity)
    {
        unset($this->items[$id]);
        $this->totalQty -= $quantity;
    }

    public function increase($id)
    {
        $storedItem = $this->items[$id];
        
        $storedItem['qty'] += 1;
        
        $this->totalQty = $storedItem['qty'];
        
        $this->totalPrice += $storedItem['item']->price;

        $this->items[$id] = $storedItem;
        
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

        return true;
    }

    public function getTotalCartQty()
    {
        $qty = 0;
        foreach ($this->items as $item) {
            $qty += $item['qty'];
        }

        return $qty;
    }

    public function getSubTotal()
    {
        $totals = 0;
        foreach ($this->items as $item) {
            $totals += $item['item']->price * $item['qty'];
        }

        return $totals;
    }

    public function getVat()
    {
        $subTotal = $this->getSubTotal();  

        $vat = $subTotal * $this->vatTax;

        return $vat;
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
 
        $totals = $this->getSubTotal() + $this->getVat();

        return $totals;
    }
}

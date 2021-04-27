<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    private $items = [];
    private $is_SC = false;
    private $has_RX = false;
    private $has_discount = false;


    protected $fillable = [
        'user_id',
        'status',
        'message',
        'customer',
        'address',
        'contact',
        'scid',
        'scid_image',
        'prescription_image',
        'cashier',
        'delivery_mode',
        'total_items',
        'vatable_sale',
        'vat_amount',
        'vat_exempt',
        'is_sc',
        'sc_discount',
        'other_discount_rate',
        'other_discount',
        'amount_due',
        'is_void',
    ];

    protected $attributes = [
        'is_void' => 0,
        'status' => 'new',
        'cashier' => 'Online Pharma',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}

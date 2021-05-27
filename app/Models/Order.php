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
        'ref_no',
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
        'delivery_fee',
        'subtotal',
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
        'estimated_dispatch_date',
        'completion_proof'
    ];

    protected $attributes = [
        'is_void' => 0,
        'status' => 'new',
        'message' => 'Order Placed',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product_return()
    {
        return $this->hasOne(ProductReturn::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}

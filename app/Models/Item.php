<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'quantity',
        'product_id',
        'name',
        'description',
        'price',
        'total_price',
        'vat_type',
        'is_prescription',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

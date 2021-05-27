<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'driver_name',
        'status',
        'is_void',
        'dispatch_date',
        'completion_date',
    ];

    protected $attributes = [
        'is_void' => 0,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

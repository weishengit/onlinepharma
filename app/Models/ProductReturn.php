<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'reason',
        'action',
        'is_active',
    ];

    /**
     * The attributes that should be filled automatically.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

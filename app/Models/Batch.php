<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_no',
        'product_id',
        'unit_cost',
        'initial_quantity',
        'remaining_quantity',
        'expiration',
        'is_active'
    ];

    /**
     * The attributes that should be filled automatically.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

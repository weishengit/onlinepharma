<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'quantity',
        'action',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => 1,
    ];


}

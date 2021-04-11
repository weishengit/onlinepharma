<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'rate',
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

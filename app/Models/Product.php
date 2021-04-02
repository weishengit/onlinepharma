<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'generic_name',
        'drug_class',
        'description',
        'price',
        'stock',
        'measurement',
        'is_prescription',
        'is_available',
        'is_active',
        'image',
    ];

    /**
     * The attributes that should be filled automatically.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => 1,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

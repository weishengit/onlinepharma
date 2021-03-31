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
        'measurement',
        'is_prescription',
        'is_available',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

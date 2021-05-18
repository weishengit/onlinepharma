<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CriticalLevelController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', '1')->get();
        $critical_products = [];

        foreach ($products as $product) {
            $count = $product->batches->where('is_active', 1)->where('expiration', '>', now())->sum('remaining_quantity');

            if ($count <= $product->critical_level) {
                $critical_products[$product->id] = $product;
                $critical_products[$product->id]['count'] = $count;
            }
        }



        return view('admin.inventory.critical')->with('critical_products', $critical_products);
    }
}

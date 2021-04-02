<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('index')
            ->with('metaTitle', 'Home');
    }
    public function contact()
    {
        return view('pages.contact')
            ->with('metaTitle', 'Contact');
    }

    public function sales()
    {
        return view('pages.sales')
            ->with('metaTitle', 'Sales');
    }

    public function about()
    {
        return view('pages.about')
            ->with('metaTitle', 'About');
    }

    public function shop()
    {
        $products = Product::paginate(12);
        return view('pages.shop')
            ->with('metaTitle', 'Shop')
            ->with('products', $products);
    }

    public function checkout()
    {
        return view('pages.checkout')
            ->with('metaTitle', 'Checkout');
    }

    public function thanks()
    {
        return view('pages.thanks')
            ->with('metaTitle', 'Thanks');
    }

    public function cart()
    {
        return view('pages.cart')
            ->with('metaTitle', 'Cart');
    }

    public function show($id)
    {
        $product = Product::find($id);

        return view('pages.show')
            ->with('metaTitle', 'Shop - ' . $product->name)
            ->with('product', $product);
    }
}

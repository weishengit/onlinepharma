<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    public function index()
    {
        $topProducts = Product::orderBy('name', 'ASC')->limit(6)->get();
        $newProducts = Product::orderBy('created_at', 'DESC')->limit(6)->get();

        return view('index')
            ->with('metaTitle', 'Home')
            ->with('topProducts', $topProducts)
            ->with('newProducts', $newProducts);
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
        $products = Product::where('is_active', 1)->where('is_available', 1)->paginate(12);
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


    public function show($id)
    {
        $product = Product::find($id);
        if ($product->is_active == 0 || $product->is_available == 0) {
            return redirect()->route('home');
        }
        return view('pages.show')
            ->with('metaTitle', 'Shop - ' . $product->name)
            ->with('product', $product);
    }
}

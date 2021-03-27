<?php

namespace App\Http\Controllers;

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
        return view('pages.shop')
            ->with('metaTitle', 'Shop');
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function thanks()
    {
        return view('pages.thanks');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function show($product = null)
    {
        $productItem = 'product from db';

        return view('pages.show')
            ->with('metaTitle', 'Shop - ' . $product . ' - Online Pharma System')
            ->with('product', $productItem);
    }
}

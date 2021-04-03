<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
{
    public function getCart()
    {
        if (!Session::get('cart')) {
            return view('pages.cart')
            ->with('metaTitle', 'Cart')
            ->with('cart', null);
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('pages.cart')
            ->with('metaTitle', 'Cart')
            ->with('cart', $cart);
    }

    public function add(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'numeric|min:1'
        ]);

        $product = Product::find($id);

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $request->quantity);

        $request->session()->put('cart', $cart);
        
        return view('pages.show')
            ->with('metaTitle', 'Shop - ' . $product->name)
            ->with('product', $product)
            ->with('message', $product->name . ' added to cart.');
    }

    public function remove($id, $quantity)
    {
        $product = Product::find($id);
        // Get id of product
        $id = $product->id;

        // Get the product array
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $cart->remove($id, $quantity);
        

        // Overwrite the product session
        Session::put('cart', $cart);

        return redirect()->route('cart')->with('message', $product->name . ' removed from cart');
    }

    public function increase($id)
    {
        $product = Product::find($id);
        // Get id of product
        $id = $product->id;

        // Get the product array
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $cart->increase($id);
        
        // Overwrite the product session
        Session::put('cart', $cart);

        return redirect()->route('cart');
    }

    public function decrease($id)
    {
        $product = Product::find($id);
        // Get id of product
        $id = $product->id;

        // Get the product array
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $hasItems = $cart->decrease($id);
        
        // Overwrite the product session
        if ($hasItems == false) {
            session()->forget('cart');
        }
        else{
            Session::put('cart', $cart);
        }
        

        return redirect()->route('cart');
    }

    public function clear()
    {
        if (Session::has('cart')) {
            session()->forget('cart');
        }

        return redirect()->route('home')->with('message', 'cart cleared');
    }
}

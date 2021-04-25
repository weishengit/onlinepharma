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

    public function add(Request $request, $id, $rx)
    {
        $request->validate([
            'quantity' => 'numeric|min:1'
        ]);

        $product = Product::find($id);

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id, $request->quantity, $rx);

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

        return redirect()->route('home')->with('message', 'Your has been cart cleared');
    }

    public function method()
    {
        return view('pages.method');
    }

    public function prescription(Request $request)
    {
        $newImageName = null;

        if ($request->image != null) {
            $newImageName = uniqid() . '-rx-' . auth()->user()->name . '.' . $request->image->extension();
            $request->image->move(public_path('images/temp/rx'), $newImageName);

            // GET THE OLD CART
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            // CHANGE THE MODEL
            $cart->setRxImage($newImageName);
            $cart->has_RX = true;

            // Overwrite the cart session
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.discount');
    }

    public function discount()
    {
        return view('pages.discount');
    }


    public function regular_checkout()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHANGE THE MODEL
        $cart->calculate_regular();

        // Overwrite the cart session
        Session::put('cart', $cart);

        return redirect()->route('cart.method');
    }

    public function senior_checkout(Request $request)
    {
        $newImageName = null;

        if ($request->image != null) {
            $newImageName = uniqid() . '-sc-' . auth()->user()->name . '.' . $request->image->extension();
            $request->image->move(public_path('images/temp/sc'), $newImageName);

            // GET THE OLD CART
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            // CHANGE THE MODEL
            $cart->setSCImage($newImageName);
            $cart->is_SC = true;
            $cart->calculate_senior();

            // Overwrite the cart session
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.method');
    }

    public function delivery()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHANGE THE MODEL
        $cart->setToDelivery();

        // Overwrite the cart session
        Session::put('cart', $cart);

        return redirect()->route('cart.finalize');
    }

    public function pickup()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHANGE THE MODEL
        $cart->setToPickup();

        // Overwrite the cart session
        Session::put('cart', $cart);

        return redirect()->route('cart.finalize');
    }

    public function finalize()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHANGE THE MODEL
        $cart->finalize();

        // Overwrite the cart session
        Session::put('cart', $cart);

        return view('pages.finalize')
            ->with('cart', session()->get('cart'));
    }
}

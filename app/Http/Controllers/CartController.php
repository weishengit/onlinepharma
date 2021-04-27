<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function remove($id)
    {
        $product = Product::find($id);
        // Get id of product
        $id = $product->id;

        // Get the product array
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $cart->remove($id);

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

        $cart->decrease($id);

        Session::put('cart', $cart);

        return redirect()->route('cart');
    }

    public function clear()
    {
        if (Session::has('cart')) {
            session()->forget('cart');
        }

        return redirect()->route('cart')->with('message', 'Your has been cart cleared');
    }

    public function method()
    {
        return view('pages.method');
    }

    public function discount()
    {
        return view('pages.discount');
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
            $cart->setHas_RX(true);
            $cart->setRx_image($newImageName);

            // Overwrite the cart session
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.discount');
    }

    public function senior(Request $request)
    {
        $newImageName = null;

        if ($request->image != null) {
            $newImageName = uniqid() . '-sc-' . auth()->user()->name . '.' . $request->image->extension();
            $request->image->move(public_path('images/temp/sc'), $newImageName);

            // GET THE OLD CART
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            // CHANGE THE MODEL
            $cart->setSc_image($newImageName);
            $cart->setIs_SC(true);


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
        $cart->setClaim_type('delivery');
        $cart->setDeliveryFee(30);
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
        $cart->setClaim_type('pickup');

        // Overwrite the cart session
        Session::put('cart', $cart);

        return redirect()->route('cart.finalize');
    }

    public function checkout()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHANGE THE MODEL
        $cart->calculate();

        // Overwrite the cart session
        Session::put('cart', $cart);

        return redirect()->route('cart.method');
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

    public function confirm()
    {
        // GET THE OLD CART
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        // CHECK FOR SC
        if ($cart->getIs_SC()) {
            if ($cart->getSc_image() == null) {
                return redirect()->route('cart')->with('message', 'You must provide a photo of your SC/PWD ID to avail the discount.');
            }
        }
        // CHECK FOR RX
        if ($cart->getHas_RX()) {
            if ($cart->getRx_image() == null) {
                return redirect()->route('cart')->with('message', 'You must provide a photo of your prescription to continue.');
            }
        }

        DB::transaction(function () use($cart) {

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'customer' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                'address' => auth()->user()->address,
                'contact' => auth()->user()->contact,
                'scid' => auth()->user()->scid,
                'scid_image' => $cart->getSc_image(),
                'prescription_image' => $cart->getRx_image(),
                'delivery_mode' => $cart->getClaim_type(),
                'delivery_fee' => $cart->getDeliveryFee(),
                'total_items' => $cart->getTotalCartQty(),
                'subtotal' => $cart->getSubTotal(),
                'vatable_sale' => $cart->getTotal_vat_able(),
                'vat_amount' => $cart->getTotal_vat_amount(),
                'vat_exempt' => $cart->getTotal_vat_exempt(),
                'is_sc' => $cart->getIs_SC(),
                'sc_discount' => $cart->getSeniorDiscount(),
                'other_discount_rate' => $cart->getOtherDiscountRate(),
                'other_discount' => $cart->getOtherDiscount(),
                'amount_due' => $cart->final_price(),
            ]);

            foreach ($cart->getItems() as $item) {
                $product = Product::find($item['item']['id']);

                if ($product == null) {
                    return redirect()->route('cart')->with('message', 'error cart product not found, clear your cart and try again');
                }

                Item::create([
                    'order_id' => $order->id,
                    'quantity' => $item['qty'],
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'total_price' => $product->price * $item['qty'],
                    'vat_type' => $product->tax->name,
                    'is_prescription' => $product->is_prescription,
                ]);
            }
        });

        session()->forget('cart');

        return view('pages.confirmation');
    }
}

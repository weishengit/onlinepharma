<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CartCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // CHECK IF CART EXIST
        if (!session()->has('cart')) {
            return redirect()->route('cart')->with('message', 'Your cart has no items');
        }
        // CHECK IF RX WAS SET
        if (session()->get('cart')->getHas_Rx() && session()->get('cart')->getRx_image() == null) {
            return redirect()->route('cart')->with('message', 'Your cart has items that requires prescription, attach a photo of your prescription below.');
        }
        // CHECK IF SC/PWD WAS SET
        if (session()->get('cart')->getIs_SC() && session()->get('cart')->getSc_image() == null) {
            return redirect()->route('cart.discount')->with('message', 'You are currently ordering as a senior/pwd, attach a photo of your sc/pwd ID');
        }
        // CHECK IF METHOD WAS SET
        if (session()->get('cart')->getClaim_type() == null) {
            return redirect()->route('cart.method')->with('message', 'You must select the method of claiming.');
        }

        return $next($request);
    }
}

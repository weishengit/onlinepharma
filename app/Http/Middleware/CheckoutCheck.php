<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckoutCheck
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
        if(!auth()->user()){
            return redirect('register');
        }

        if(is_null(auth()->user()->address) ||
            is_null(auth()->user()->contact) ||
            is_null(auth()->user()->first_name)||
            is_null(auth()->user()->last_name) ||
            is_null(auth()->user()->scid)
        ){
            return redirect()->route('profile.edit')->with('message', 'Please set up your profile to continue checkout, Fill all fields.');
        }

        return $next($request);
    }
}

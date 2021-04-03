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

        if(is_null(auth()->user()->address)){
            return redirect('/profile/edit')->with('message', 'Please set up your profile to recieve deliveries');
        }

        return $next($request);
    }
}

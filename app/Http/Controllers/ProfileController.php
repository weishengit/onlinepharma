<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->user()->id)->limit(5)->get();

        return view('profile.index')
            ->with('orders', $orders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'contact' => 'nullable|digits:11',
            'address' => 'nullable|string|max:255',
            'scid' => 'nullable|string|max:255',
        ]);

        User::where('id', auth()->user()->id)
            ->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'contact' => $request->input('contact'),
                'address' => $request->input('address'),
                'scid' => $request->input('scid'),
            ]);

        return redirect()
            ->route('profile.index')
            ->with('message', 'profile updated.');
    }

    public function orders()
    {
        $new_orders = Order::where('user_id', auth()->user()->id)
            ->where(function($query) {
                $query->where('status', 'new')->orWhere('status', 'pending');
            })
            ->get();

        $old_orders = Order::where('user_id', auth()->user()->id)
            ->where(function($query) {
                $query->where('status', '!=', 'new')->Where('status', '!=', 'pending');
            })
            ->get();


        return view('profile.orders')
            ->with('new_orders', $new_orders)
            ->with('old_orders', $old_orders);
    }

    public function order($order_id = null)
    {
        $order = Order::find($order_id);

        if ($order_id == null) {
            return redirect()->route('profile.orders')->with('message', 'Not a valid order id.');
        }

        $items = Item::where('order_id', $order_id)->get();

        return view('profile.order')
            ->with('order', $order)
            ->with('items', $items);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    public function index()
    {
        $order_count = Order::where('status', 'new')->where('is_void', 0)->count();
        $new_orders = Order::where('status', 'new')->where('is_void', 0)->get();
        return view('admin.pharmacist.index')->with('new_orders', $new_orders)->with('count', $order_count);
    }

    public function show($id)
    {
        $order = Order::find($id);
        $items = Item::where('order_id', $order->id)->get();

        if ($order == null) {
            return redirect()->route('admin.pharmacist.index')->with('message', 'Order not found.');
        }

        return view('admin.pharmacist.show')
            ->with('order', $order)
            ->with('items', $items);
    }
}

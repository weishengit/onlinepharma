<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function show($search = null)
    {
        $title = '';
        $orders = null;

        if ($search == 'all') {
            $orders = Order::all() ?? null;
            $title = 'All';
        }
        if ($search == 'new') {
            $orders = Order::where('status', 'new')->where('is_void', 0)->get() ?? null;
            $title = 'New';
        }
        if ($search == 'void') {
            $orders = Order::where('status', 'void')->where('is_void', 1)->get() ?? null;
            $title = 'Void';
        }
        if ($search == 'completed') {
            $orders = Order::where('status', 'completed')->where('is_void', 0)->get() ?? null;
            $title = 'Completed';
        }

        if ($orders == null) {
            return redirect()->route('admin.order.index')->with('message', 'there was an error fetching orders.');
        }

        return view('admin.order.show')
            ->with('orders', $orders)
            ->with('title', $title);
    }

    public function create()
    {
        return view('admin.order.create');
    }

    public function store()
    {
        # code...
    }

    public function edit($id)
    {
        $order = Order::find($id);
        $items = Item::where('order_id', $order->id)->get();

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        return view('admin.order.edit')
            ->with('order', $order)
            ->with('items', $items);
    }

    public function update()
    {
        # code...
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        // DISABLE DISCOUNT
        Order::where('id', $order->id)
        ->update([
            'status' => 'void',
            'is_void' => 1,
        ]);


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->id . ' has been voided.');
    }
}

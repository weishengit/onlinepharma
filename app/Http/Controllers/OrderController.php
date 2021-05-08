<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Batch;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($search == 'pending') {
            $orders = Order::where('status', 'pending')->where('is_void', 0)->get() ?? null;
            $title = 'Pending';
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

    public function accept(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        $items = Item::where('order_id', $order->id)->get();
        foreach ($items as $item) {
            $stock = Batch::where('product_id', $item->product_id)
                ->where('is_active', 1)
                ->groupBy('product_id')
                ->sum('remaining_quantity');

            if ($stock == null || $stock < $item->quantity) {
                return redirect()->back()->with('message', 'Not enough "' . $item->name . '" in stock to complete the order #' . $order->id . '.');
            }
        }

        // MARK AS PENDING
        Order::where('id', $order->id)
        ->update([
            'message' => $request->input('reason'),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->id . ' has been accepted and now pending for dispatch.');
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

    public function complete(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        $items = Item::where('order_id', $order->id)->get();
        foreach ($items as $item) {
            $stock = Batch::where('product_id', $item->product_id)
                ->where('is_active', 1)
                ->groupBy('product_id')
                ->sum('remaining_quantity');

            if ($stock == null || $stock < $item->quantity) {
                return redirect()->back()->with('message', 'Not enough "' . $item->name . '" in stock to complete the order #' . $order->id . '.');
            }

            DB::transaction(function () use($item, $order, $request) {
                $batches = Batch::where('product_id', $item->product_id)
                ->where('is_active', 1)
                ->oldest()
                ->get();

                $qty = $item->quantity;

                foreach ($batches as $batch) {
                    if ($qty > 0) {
                        if ($batch->remaining_quantity - $qty < 0) {
                            $qty -= $batch->remaining_quantity;
                            $batch->remaining_quantity = 0;
                            $batch->is_active = false;
                            $batch->save();
                        }
                        else
                        {
                            $batch->remaining_quantity = $batch->remaining_quantity - $qty;
                            $batch->save();
                            $qty = 0;
                        }

                    }
                }

                // MARK AS PENDING
                Order::where('id', $order->id)
                ->update([
                    'message' => $request->input('reason'),
                    'status' => 'completed',
                ]);
            });

        }


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->id . ' has been marked as complete.');
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        // DISABLE DISCOUNT
        Order::where('id', $order->id)
        ->update([
            'message' => $request->input('reason'),
            'status' => 'void',
            'is_void' => 1,
        ]);


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->id . ' has been voided.');
    }
}

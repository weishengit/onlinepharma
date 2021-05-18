<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Batch;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nexmo\Laravel\Facade\Nexmo;

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
        if ($search == 'dispatched') {
            $orders = Order::where('status', 'dispatched')->where('is_void', 0)->get() ?? null;
            $title = 'Dispatched';
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

        $request->validate([
            'est_date' => 'required|date_format:Y-m-d',
        ]);

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
            'estimated_dispatch_date' => $request->input('est_date'),
            'message' => 'Order Confirmed',
            'status' => 'pending',
        ]);

        $receiver = env('NEXMO_TEST_NUMBER', '63' . ltrim($order->contact, $order->contact[0]));
        Nexmo::message()->send([
            'to' => $receiver,
            'from' => config('app.name', 'Online Pharma'),
            'text' => 'Ref#'. $order->ref_no  .' : Your Order Has Been Accepted.',
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
                ->where('expiration', '>', Carbon::now())
                ->oldest('expiration')
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

                // MARK AS COMPETED
                Order::where('id', $order->id)
                ->update([
                    'message' => 'Order Completed',
                    'status' => 'completed',
                ]);

                $receiver = env('NEXMO_TEST_NUMBER', '63' . ltrim($order->contact, $order->contact[0]));
                Nexmo::message()->send([
                    'to' => $receiver,
                    'from' => config('app.name', 'Online Pharma'),
                    'text' => 'Ref#'. $order->ref_no  .' : Your Order Has Been Completed.',
                ]);
            });

        }


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->id . ' has been marked as complete.');
    }

    public function dispatch($id)
    {
        $order = Order::find($id);

        if ($order == null) {
            return redirect()->route('admin.order.index')->with('message', 'Order not found.');
        }

        // DISPATCH ORDER
        $msg = 'Dispatched';
        $text = 'Ref#'. $order->ref_no  .' Your Order Is Ready.';
        if ($order->delivery_mode == 'delivery') {
            $msg = 'On The Way';
            $text = 'Ref#'. $order->ref_no  .' : Your Order Is On The Way. Please Prepare The Requirements.';
        }
        if ($order->delivery_mode == 'pickup') {
            $msg = 'Ready For Pickup';
            $text = 'Ref#'. $order->ref_no  .' : Your Order Ready. Please Bring The Requirements When Claiming.';
        }

        Order::where('id', $order->id)
        ->update([
            'message' => $msg,
            'status' => 'dispatched',
        ]);

        $receiver = env('NEXMO_TEST_NUMBER', '63' . ltrim($order->contact, $order->contact[0]));
        Nexmo::message()->send([
            'to' => $receiver,
            'from' => config('app.name', 'Online Pharma'),
            'text' => $text,
        ]);


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->ref_no . ' has been dispatched.');
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::find($id);

        $request->validate([
            'reason' => 'required|string|max:30'
        ]);

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

        $receiver = env('NEXMO_TEST_NUMBER', '63' . ltrim($order->contact, $order->contact[0]));
        Nexmo::message()->send([
            'to' => $receiver,
            'from' => config('app.name', 'Online Pharma'),
            'text' => 'Ref#'. $order->ref_no  .' : Your Order Has Been Cancelled. - Reason: ' . $request->input('reason'),
        ]);


        return redirect()
            ->route('admin.order.index')
            ->with('message', 'Order #' . $order->ref_no . ' has been voided.');
    }
}

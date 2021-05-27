<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Batch;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function index()
    {
        $pending_count = Order::where('status', 'pending')->where('is_void', 0)->count();
        $dispatched_count = Order::where('status', 'dispatched')->where('is_void', 0)->count();

        return view('admin.cashier.index')
            ->with('pending_count', $pending_count)
            ->with('dispatched_count', $dispatched_count);
    }

    public function show($filter = 'pending')
    {
        $title = '';
        $count = 0;
        $orders = null;
        if ($filter == 'pending') {
            $orders = Order::where('status', 'pending')->where('is_void', 0)->get();
            $count = Order::where('status', 'pending')->where('is_void', 0)->count();
            $title = 'Pending';
        }
        if ($filter == 'dispatched') {
            $orders = Order::where('status', 'dispatched')->where('is_void', 0)->get();
            $count = Order::where('status', 'dispatched')->where('is_void', 0)->count();
            $title = 'Dispatched';
        }

        return view('admin.cashier.show')
            ->with('orders', $orders)
            ->with('count', $count)
            ->with('title', $title);
    }

    public function edit($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.cashier.index')->with('message', 'Order not found.');
        }

        $items = Item::where('order_id', $order->id)->get();

        return view('admin.cashier.edit')
            ->with('order', $order)
            ->with('items', $items);
    }

    public function finish($id)
    {
        $order = Order::find($id);
        if ($order == null || $order->is_void == 1 || $order->status != 'dispatched' || $order->delivery_mode != 'delivery') {
            return redirect()->route('admin.cashier.index')->with('message', 'Order not found.');
        }
        return view('admin.cashier.complete')->with('order', $order);
    }

    public function complete(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order == null || $order->is_void == 1 || $order->status != 'dispatched' || $order->delivery_mode != 'delivery') {
            return redirect()->route('admin.cashier.index')->with('message', 'Order not found.');
        }

        $request->validate([
            'image' => 'mimes:jpg,jpeg,png|max:1096'
        ]);

        $items = Item::where('order_id', $order->id)->get();
        foreach ($items as $item) {
            $stock = Batch::where('product_id', $item->product_id)
                ->where('is_active', 1)
                ->where('expiration', '>', Carbon::now())
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
                // PROOF IMAGE
                $newImageName = null;
                if ($request->image != null) {
                    $newImageName = $order->ref_no . '-proof-' . auth()->user()->name . '.' . $request->image->extension();
                    $request->image->move(public_path('images/temp/proof'), $newImageName);
                }

                // MARK AS COMPETED
                Order::where('id', $order->id)
                ->update([
                    'message' => 'Order Completed',
                    'status' => 'completed',
                    'completion_proof' => $newImageName,
                ]);

                if ($order->delivery_mode == 'delivery') {
                    Delivery::where('order_id', $order->id)
                    ->update([
                        'status' => 'completed',
                        'completion_date' => now(),
                    ]);
                }

                $receiver = '';
                if (env('NEXMO_TEST_MODE')) {
                    $receiver = env('NEXMO_TEST_NUMBER');
                }
                else{
                    $receiver = '63' . ltrim($order->contact, $order->contact[0]);
                }
                Nexmo::message()->send([
                    'to' => $receiver,
                    'from' => config('app.name', 'Online Pharma'),
                    'text' => 'Ref#'. $order->ref_no  .' : Your Order Has Been Completed.',
                ]);
            });

        }


        return redirect()->route('admin.cashier.index')->with('message', 'Order#' . $order->ref_no  .' Completed.');
    }
}

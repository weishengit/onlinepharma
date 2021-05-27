<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('is_void', 0)->get();
        return view('admin.delivery.index')->with('deliveries', $deliveries);
    }

    // CREATE DELIVERY
    public function create($id)
    {
        $order = Order::find($id);
        if ($order == null || $order->delivery_mode != 'delivery' || $order->is_void == 1) {
            return redirect()->route('admin.cashier.index')->with('message', 'Order not found.');
        }
        return view('admin.delivery.create')->with('order', $order);
    }

    public function store(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('admin.cashier.index')->with('message', 'Order not found.');
        }

        $request->validate([
            'driver_id' => 'required|string',
            'driver_name' => 'required|string',
        ]);

        DB::transaction(function () use($order, $request){


            Delivery::create([
                'order_id' => $order->id,
                'status' => 'On The Way',
                'driver_id' => $request->input('driver_id'),
                'driver_name' => $request->input('driver_name'),
                'dispatch_date' => now()
            ]);

            Order::where('id', $order->id)
            ->update([
                'message' => 'On The Way',
                'status' => 'dispatched',
            ]);

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
                'text' => 'Ref#'. $order->ref_no  .' : Your Order Is On The Way. Please Prepare The Requirements.',
            ]);
        });

        return redirect()
            ->route('admin.cashier.index')
            ->with('message', 'Order #' . $order->ref_no . ' has been dispatched.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::find($id);
        if ($delivery == null) {
            return redirect()->route('admin.delivery.index')->with('message', 'Delivery not found.');
        }
        return view('admin.delivery.show')->with('delivery', $delivery);
    }

}

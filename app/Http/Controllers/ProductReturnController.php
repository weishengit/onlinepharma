<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returns = ProductReturn::all();
        return view('admin.return.index')->with('returns', $returns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.return.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_ref_no' => 'required|exists:orders,ref_no',
            'reason' => 'required|string|max:999',
            'action' => 'required|string',
        ]);

        $order = Order::where('ref_no', $request->input('order_ref_no'))->first();

        DB::transaction(function () use($request, $order){
            ProductReturn::create([
                'order_id' => $order->id,
                'reason' => $request->input('reason'),
                'action' => $request->input('action'),
            ]);

            $order->message = 'Returned';
            $order->status = 'returned';
            $order->is_void = 1;
            $order->save();
        });

        return redirect()->route('admin.return.index')->with('message', $request->input('order_ref_no') . ' has been returned.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $return = ProductReturn::find($id);
        if ($return == null) {
            return redirect()->route('admin.return.show')->with('message', 'return number not found!');
        }

        return view('admin.return.show')->with('return', $return);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductReturn $productReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductReturn $productReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductReturn  $productReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductReturn $productReturn)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Product;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.batch.index')
            ->with('products', Product::where('is_available', 1)->where('is_active', 1)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'product not found!');
        }

        return view('admin.batch.create')->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'batch_no' => 'required|unique:batches,batch_no',
            'unit_cost' => 'required|numeric',
            'quantity' => 'required|numeric',
            'expiration' => 'required|date_format:Y-m-d',
        ]);

        Batch::create([
            'product_id' => $id,
            'batch_no' => $request->input('batch_no'),
            'unit_cost' => $request->input('unit_cost'),
            'initial_quantity' => $request->input('quantity'),
            'remaining_quantity' => $request->input('quantity'),
            'expiration' => $request->input('expiration'),
        ]);

        return redirect()
            ->route('admin.batch.show', ['batch' => $id])
            ->with('message', 'Added Batch#' . $request->input('batch_no') . ' to inventory');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'product not found!');
        }

        return view('admin.batch.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $batch = Batch::find($id);
        if ($batch == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'batch number not found!');
        }

        return view('admin.batch.edit')->with('batch', $batch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $batch = Batch::find($id);
        if ($batch == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'batch number not found!');
        }

        $request->validate([
            'batch_no' => 'required|string|max:255|unique:batches,batch_no,'. $batch->id,
            'unit_cost' => 'required|numeric',
            'i_quantity' => 'required|numeric',
            'r_quantity' => 'required|numeric',
            'expiration' => 'required|date_format:Y-m-d',
        ]);

        Batch::where('id', $batch->id)
            ->update([
                'batch_no' => $request->input('batch_no'),
                'unit_cost' => $request->input('unit_cost'),
                'initial_quantity' => $request->input('i_quantity'),
                'remaining_quantity' => $request->input('r_quantity'),
                'expiration' => $request->input('expiration'),
        ]);

        return redirect()
            ->route('admin.batch.show', ['batch' => $batch->product->id])
            ->with('message', 'Updated Batch#' . $request->input('batch_no'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch = Batch::find($id);
        if ($batch == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'batch number not found!');
        }

        $batch->is_active = 0;
        $batch->save();

        return redirect()
            ->route('admin.batch.show', ['batch' => $batch->product->id])
            ->with('message', 'Disabled Batch#' . $batch->batch_no);
    }

    public function activate($id)
    {
        $batch = Batch::find($id);
        if ($batch == null) {
            return redirect()->route('admin.inventory.index')->with('message', 'batch number not found!');
        }

        $batch->is_active = 1;
        $batch->save();

        return redirect()
            ->route('admin.batch.show', ['batch' => $batch->product->id])
            ->with('message', 'Activated Batch#' . $batch->batch_no);
    }
}

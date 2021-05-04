<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();

        return view('admin.sale.index')
            ->with('sales' ,$sales);
    }

    public function create($id)
    {
        $product = Product::find($id);

        if ($product == null) {
            return redirect()->route('admin.sale.index')->with('message', 'Product not found!');
        }

        return view('admin.sale.create')->with('product', $product);
    }

    public function edit($id)
    {
        $sale = Sale::find($id);

        if ($sale == null) {
            return redirect()->route('admin.sale.index')->with('message', 'Sale not found!');
        }

        return view('admin.sale.edit')->with('sale', $sale);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $product = Product::find($id);
        if ($product == null) {
            return redirect()->route('admin.sale.index')->with('message', 'Product not found!');
        }

        Sale::create([
            'product_id' => $product->id,
            'is_percent' => $request->input('type'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()
            ->route('admin.sale.index')
            ->with('message', $product->name . ' has been put on sale.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|numeric',
            'rate' => 'required|numeric',
        ]);

        $sale = Sale::find($id);
        if ($sale == null) {
            return redirect()->route('admin.sale.index')->with('message', 'Sale not found!');
        }

        Sale::where('id', $sale->id)
            ->update([
            'is_percent' => $request->input('type'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()
            ->route('admin.sale.index')
            ->with('message', $sale->product->name . ' has been updated.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        $product = Product::find($id);

        if ($product == null) {
            return redirect()->route('admin.sale.index')->with('message', 'Product not found!');
        }

        return view('admin.sale.show')->with('product', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if ($sale == null) {
            return redirect()->route('admin.sale.index')->with('message', 'sale not found!');
        }

        $sale->delete();

        return redirect()->route('admin.sale.index')->with('message', 'sale successfully ended!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tax.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tax.create');
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
            'name' => 'required|unique:taxes,name',
            'rate' => 'required|numeric',
        ]);

        Tax::create([
            'name' => $request->input('name'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()
            ->route('admin.tax.index')
            ->with('message', 'Tax ' . $request->input('name') . ' has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show($tax = null)
    {
        $taxes = null;
        $title = '';

        if ($tax == 'inactive') {
            // GETS INACTIVE CATEGORIES
            $taxes = Tax::where('is_active', 0)->where('id', '!=', 1)->get() ?? null;
            $title = 'Inactive';
        } else {
            // GETS ALL ACTIVE CATEGORIES
            $taxes = Tax::where('is_active', 1)->where('id', '!=', 1)->get() ?? null;
            $title = 'Active';
        }

        if ($taxes == null) {
            return redirect()->route('admin.tax.index')->with('message', 'there are currently no taxes');
        }

        return view('admin.tax.show')
            ->with('taxes', $taxes)
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax = Tax::where('id', $id)->first() ?? null;

        if ($tax == null) {
            return redirect()->route('admin.tax.index')->with('message', 'Tax not found.');
        }

        return view('admin.tax.edit')
            ->with('tax', $tax);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:taxes,name,' . $id,
            'rate' => 'required|numeric',
        ]);

        Tax::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'rate' => $request->input('rate'),
            ]);

        return redirect()
            ->route('admin.tax.index')
            ->with('message', 'Tax ' . $request->input('name') . ' has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tax = Tax::where('id', $id)->first()  ?? null;

        if ($tax == null) {
            return redirect()->route('admin.tax.index')->with('message', 'Tax not found.');
        }

        DB::transaction(function () use($tax){
            // SET TAX TO NONE
            Product::where('tax_id', $tax->id)
            ->update([
                'tax_id' => 1
            ]);

            // DISABLE TAX
            Tax::where('id', $tax->id)
            ->update([
                'is_active' => 0
            ]);
        });



        return redirect()
            ->route('admin.tax.index')
            ->with('message', 'Tax ' . $tax->name . ' has been disabled. Products related to ' .$tax->name. ' has been set to "Tax - none');
    }

    /**
     * Active taxes
     *
     * @param int $id
     * @return void
     */
    public function activate($id)
    {
        // CHECK IF CATEOGRY EXIST
        $tax = Tax::where('id', $id)->first() ?? null;
        if ($tax == null) {
            return redirect()->route('admin.tax.index')->with('message', 'tax not found.');
        }
        $name = $tax->name;

        Tax::where('id', $id)
            ->update([
                'is_active' => 1,
            ]);

        return redirect()->route('admin.tax.index')->with('message', $name . ' has been reactivated');
    }
}

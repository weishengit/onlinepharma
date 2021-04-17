<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.discount.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create');
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
            'name' => 'required|unique:discounts,name',
            'rate' => 'required|numeric',
        ]);

        Discount::create([
            'name' => $request->input('name'),
            'rate' => $request->input('rate'),
        ]);

        return redirect()
            ->route('admin.discount.index')
            ->with('message', 'Discount ' . $request->input('name') . ' has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($discount = null)
    {
        $discounts = null;
        $title = '';

        if ($discount == 'inactive') {
            // GETS INACTIVE CATEGORIES
            $discounts = Discount::where('is_active', 0)->where('id', '!=', 1)->get() ?? null;
            $title = 'Inactive';
        } else {
            // GETS ALL ACTIVE CATEGORIES
            $discounts = Discount::where('is_active', 1)->where('id', '!=', 1)->get() ?? null;
            $title = 'Active';
        }

        if ($discounts == null) {
            return redirect()->route('admin.discount.index')->with('message', 'there are currently no discounts');
        }

        return view('admin.discount.show')
            ->with('discounts', $discounts)
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount = Discount::where('id', $id)->first() ?? null;

        if ($discount == null) {
            return redirect()->route('admin.discount.index')->with('message', 'Discount not found.');
        }

        return view('admin.discount.edit')
            ->with('discount', $discount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:discounts,name,' . $id,
            'rate' => 'required|numeric',
        ]);

        Discount::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'rate' => $request->input('rate'),
            ]);

        return redirect()
            ->route('admin.discount.index')
            ->with('message', 'Discount ' . $request->input('name') . ' has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = Discount::where('id', $id)->first()  ?? null;

        if ($discount == null) {
            return redirect()->route('admin.discount.index')->with('message', 'Discount not found.');
        }

        // DISABLE DISCOUNT
        Discount::where('id', $discount->id)
        ->update([
            'is_active' => 0
        ]);


        return redirect()
            ->route('admin.discount.index')
            ->with('message', 'Discount ' . $discount->name . ' has been disabled.');
    }

    /**
     * Active Discount.
     *
     * @param int $id
     * @return void
     */
    public function activate($id)
    {
        // CHECK IF DISCOUNT EXIST
        $discount = Discount::where('id', $id)->first() ?? null;
        if ($discount == null) {
            return redirect()->route('admin.discount.index')->with('message', 'discount not found.');
        }
        $name = $discount->name;

        Discount::where('id', $id)
            ->update([
                'is_active' => 1,
            ]);

        return redirect()->route('admin.discount.index')->with('message', $name . ' has been reactivated');
    }
}

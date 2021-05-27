<?php

namespace App\Http\Controllers;

use App\Models\InvMovement;
use Illuminate\Http\Request;

class InvMovementController extends Controller
{
    public function index()
    {
        $items = InvMovement::where('is_active', 1)->latest()->limit(100)->get();
        return view('admin.invmovement.index')->with('items', $items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|string',
            'action' => 'required|string'
        ]);


    }

    public function destroy(InvMovement $invMovement)
    {
        //
    }
}

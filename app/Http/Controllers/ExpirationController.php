<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class ExpirationController extends Controller
{
    public function index()
    {
        $batches = Batch::where('is_active', '1')->where('expiration', '<', now()->addMonths(6))->get();

        return view('admin.inventory.expiration')->with('batches', $batches);
    }
}

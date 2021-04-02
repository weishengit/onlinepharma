<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;

class ProfileDelete extends Controller
{
    public function show()
    {
        return view('profile.delete.show');
    }

    public function destroy()
    {
        DB::transaction(function () {
            
            User::where('id', auth()->user()->id)
            ->update([
                'is_active' => 0,
            ]);

            Ban::create([
            'user_id' => auth()->user()->id,
            'reason' => 'Deactivated own account',
            'banned_by' => auth()->user()->name,
            ]);
            
        });

        return redirect('/')->with('message', 'account deactivated');
    }
}

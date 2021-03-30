<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('profile.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);
        
        User::where('id', auth()->user()->id)
            ->update([
                'password' => Hash::make($request->input('password')),
            ]);
            
        return redirect()
            ->route('profile.edit')
            ->with('message', 'Your password was successfully updated');
    }
}

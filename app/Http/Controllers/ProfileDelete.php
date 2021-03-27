<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class ProfileDelete extends Controller
{
    public function show()
    {
        return view('profile.delete.show');
    }

    public function destroy()
    {
        $user = User::where('id', auth()->user()->id);
        $user->delete();

        return redirect('/')->with('message', 'account deleted');
    }
}

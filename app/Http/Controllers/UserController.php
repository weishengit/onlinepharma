<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function showAdmin()
    {
        $users = User::where('is_admin', 1)->where('is_active', 1)->get();

        return view('admin.user.admin.show')
            ->with('users', $users);
    }

    public function showCustomer()
    {
        $users = User::where('is_admin', 0)->where('is_active', 1)->get();

        return view('admin.user.customer.show')
            ->with('users', $users);
    }

    public function showInactive()
    {
        $users = User::where('is_active', 0)->get();

        return view('admin.user.inactive.show')
            ->with('users', $users);
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first() ?? null;

        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }

        if(auth()->user()->id == $user->id){
            return redirect()->route('admin.user.index')->with('message', 'cannot edit your account while in use.');
        }

        return view('admin.user.edit')
            ->with('user', $user);
    }
}

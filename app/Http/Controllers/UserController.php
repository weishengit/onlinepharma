<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($filter = '')
    {
        $users = '';

        switch($filter){
            case 'admin' :
                $users = User::where('is_admin', 1)->get();
            break;
            case 'customer' :
                $users = User::where('is_admin', 0)->get();
            break;
            case 'senior' :
                $users = User::whereNotNull('scid')->get();
            break;
            case 'inactive' :
                $users = User::where('is_active', 0)->get();
            break;
            default:
                $users = User::orderBy('name', 'DESC')->get();
            break;
        }

        return view('admin.user.show')
            ->with('users', $users);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Make account an admin.
     *
     * Promotes the selected user.
     *
     * @param int $id
     * @return void
     */
    public function store($id)
    {
        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;
        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;

        // CHECK IF ALREADY ADMIN
        if ($user->is_admin == 1 && $user->role->role_name == 'admin') {
            return redirect()->route('admin.user.index')->with('message', $name .' is already admin.');
        }

        DB::transaction(function () use($id){
            User::where('id', $id)
            ->update([
                'is_admin' => 1,
            ]);

            Role::where('user_id', $id)
            ->update([
                'role_name' => 'admin',
            ]);
        });


        return redirect()->route('admin.user.index')->with('message',  $name .' user has been given admin.');
    }

    /**
     * Remove account admin.
     *
     * removes admin from the selected user.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;

        if ($user == null) {
            // IF NO USER
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;

        // CHECK IF NOT ADMIN
        if ($user->is_admin == 0 && $user->role->role_name != 'admin') {
            return redirect()->route('admin.user.index')->with('message', $name . ' is already not an admin.');
        }

        DB::transaction(function () use($id){
            User::where('id', $id)
            ->update([
                'is_admin' => 0,
            ]);

            Role::where('user_id', $id)
            ->update([
                'role_name' => 'user',
            ]);
        });

        return redirect()->route('admin.user.index')->with('message', $name . ' is now a regular user.');
    }

    public function manage()
    {
        return view('admin.manage');
    }
    public function manager($id)
    {
        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;
        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;

        // CHECK IF ALREADY ADMIN
        if ($user->is_admin == 1 && $user->role->role_name == 'admin') {
            return redirect()->route('admin.user.index')->with('message', $name .' is already admin.');
        }

        DB::transaction(function () use($id){
            User::where('id', $id)
            ->update([
                'is_admin' => 1,
            ]);

            Role::where('user_id', $id)
            ->update([
                'role_name' => 'manager',
            ]);
        });

        return redirect()->route('admin.user.index')->with('message',  $name .' user has been given manager permissions.');
    }

    public function pharmacist($id)
    {
        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;
        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;

        // CHECK IF ALREADY ADMIN
        if ($user->is_admin == 1 && $user->role->role_name == 'admin') {
            return redirect()->route('admin.user.index')->with('message', $name .' is already admin.');
        }

        DB::transaction(function () use($id){
            User::where('id', $id)
            ->update([
                'is_admin' => 1,
            ]);

            Role::where('user_id', $id)
            ->update([
                'role_name' => 'pharmacist',
            ]);
        });

        return redirect()->route('admin.user.index')->with('message',  $name .' user has been given pharmacist permissions.');
    }

    public function cashier($id)
    {
        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;
        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;

        // CHECK IF ALREADY ADMIN
        if ($user->is_admin == 1 && $user->role->role_name == 'admin') {
            return redirect()->route('admin.user.index')->with('message', $name .' is already admin.');
        }

        DB::transaction(function () use($id){
            User::where('id', $id)
            ->update([
                'is_admin' => 1,
            ]);

            Role::where('user_id', $id)
            ->update([
                'role_name' => 'cashier',
            ]);
        });

        return redirect()->route('admin.user.index')->with('message',  $name .' user has been given cashier permissions.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        if ($user->is_admin == 1) {
            return redirect()->route('admin.user.index')->with('message', $name .' is already admin.');
        }

        User::where('id', $id)
        ->update([
            'is_admin' => 1,
        ]);

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
        if ($user->is_admin == 0) {
            return redirect()->route('admin.user.index')->with('message', $name . ' is already not an admin.');
        }

        User::where('id', $id)
        ->update([
            'is_admin' => 0,
        ]);

        return redirect()->route('admin.user.index')->with('message', $name . ' was removed from admin.');
    }

    public function manage()
    {
        return view('admin.manage');
    }
}

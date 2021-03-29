<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;

class BanController extends Controller
{
    public function create($id)
    {
        $user = User::where('id', $id)->first() ?? null;

        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        if ($user->is_active == 0) {
            return redirect()->route('admin.user.index')->with('message', 'user already banned.');
        }

        User::where('id', $id)
            ->update([
                'is_active' => 0,
            ]);

        Ban::create([
            'user_id' => $id,
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('admin.user.index')->with('message', 'user has been banned.');

    }

    public function store(Request $request, $id)
    {
        $user = User::where('id', $id)->first() ?? null;

        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        if ($user->is_active == 0) {
            return redirect()->route('admin.user.index')->with('message', 'user already banned.');
        }

        User::where('id', $id)
            ->update([
                'is_active' => 0,
            ]);

        Ban::create([
            'user_id' => $id,
            'reason' => $request->input('reason'),
        ]);

        return redirect()->route('admin.user.index')->with('message', 'user has been banned.');
    }

    public function update($id)
    {
        $user = User::where('id', $id)->first() ?? null;

        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }

        User::where('id', $id)
            ->update([
                'is_active' => 0,
            ]);

        if ($user->is_active == 1) {
            return redirect()->route('admin.user.index')->with('message', 'user already active.');
        }
    }
}

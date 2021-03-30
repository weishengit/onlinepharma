<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BanController extends Controller
{
    /**
     * Create account ban.
     * 
     * Bans the selected user.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        // VALIDATE
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // CHECK USER
        $user = User::where('id', $id)->first() ?? null;
        if ($user == null) {
            return redirect()->route('admin.user.index')->with('message', 'user not found.');
        }
        $name = $user->name;
        
        // CHECK IF ALREADY BANNED
        if ($user->is_active == 0) {
            return redirect()->route('admin.user.index')->with('message', 'user already banned.');
        }

        DB::transaction(function () use($id, $request) {
            User::where('id', $id)
            ->update([
                'is_active' => 0,
            ]);

            Ban::create([
            'user_id' => $id,
            'reason' => $request->input('reason'),
            'banned_by' => auth()->user()->name,
        ]);
        });

        return redirect()->route('admin.user.index')->with('message',  $name .' user has been banned.');
    }

    /**
     * Remove account Ban.
     * 
     * Unbans the selected user.
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

        // CHECK IF ALREADY BANNED
        if ($user->is_active != 0) {
            return redirect()->route('admin.user.index')->with('message', $name . ' is already unbanned.');
        }

        $ban = Ban::where('user_id', $id)->first() ?? null;

        // TRY TO UNBAN USER
        DB::transaction(function () use($id, $ban) {
            // ACTIVATE ACCOUNT
            User::where('id', $id)
            ->update([
                'is_active' => 1,
            ]);
            
            // DELETE BAN
            $ban->delete();
        });

        return redirect()->route('admin.user.index')->with('message', $name . ' sucessfully unbanned.');
    }
}

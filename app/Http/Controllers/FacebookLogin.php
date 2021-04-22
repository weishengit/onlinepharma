<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookLogin extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        $user = User::firstOrCreate(
            [
                'email' => $user->email
            ],
            [
                'name' => $user->name,
                'password' => Hash::make(Str::random(24))
            ]);

        Auth::login($user, true);

        return redirect()->route('home');
    }
}

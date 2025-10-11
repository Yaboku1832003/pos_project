<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
// use App\Http\Controllers\SocialLoginController;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
{
    $socialLoginData = Socialite::driver($provider)->user();

    // Try to find the user by email first
    $user = User::where('email', $socialLoginData->email)->first();

    if ($user) {
        // If user exists, update their provider info
        $user->update([
            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'name' => $socialLoginData->name,
            'nickname' => $socialLoginData->nickname,
            'profile' => $socialLoginData->avatar,
        ]);
    } else {
        // If no user exists, create a new one
        $user = User::create([
            'name' => $socialLoginData->name,
            'email' => $socialLoginData->email,
            'nickname' => $socialLoginData->nickname,
            'profile' => $socialLoginData->avatar,
            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'role' => 'user'
        ]);
    }

    Auth::login($user);

    return to_route('user#homePage');
}

}

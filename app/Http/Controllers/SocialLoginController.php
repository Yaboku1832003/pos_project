<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialLoginController;

class SocialLoginController extends Controller
{
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider){
        // $data = Socialite::driver($provider)->user();
        // dd($data);

        $socialLoginData = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialLoginData->id,
        ],
        [
            'name' => $socialLoginData->name,
            'email' => $socialLoginData->email,
            'nickname' => $socialLoginData->nickname,
            'profile' => $socialLoginData->avatar,
            'provider' => $provider, //google or github
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'role' => 'user'
        ]);

        Auth::login($user);

        return to_route('user#dashboard');
    }
}

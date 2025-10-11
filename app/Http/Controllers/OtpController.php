<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
class OtpController extends Controller
{
    public function showOtpForm()
{
    if (!Session::has('registration_data')) {
        return redirect()->route('register')->withErrors(['msg' => 'Session expired. Please register again.']);
    }

    return view('auth.verify-otp');
}

public function resendOtp(Request $request)
{
    $data = Session::get('registration_data');

    if (!$data) {
        return redirect()->route('register')->withErrors(['msg' => 'Session expired. Please register again.']);
    }

    $existingOtp = Otp::where('identifier', $data['email'])->first();
    if ($existingOtp && $existingOtp->updated_at->diffInSeconds(now()) < 60) {
        return back()->withErrors(['otp' => 'Please wait before requesting another OTP.']);
    }

    $otp = rand(100000, 999999);

    Otp::updateOrCreate(
        ['identifier' => $data['email']],
        [
            'otp_code'   => $otp,
            'expires_at' => now()->addMinutes(10),
        ]
    );

    Mail::to($data['email'])->send(new SendOtpMail($otp));

    return back()->with('status', 'A new OTP has been sent to your email.');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => ['required', 'digits:6'],
    ]);

    $data = Session::get('registration_data');
    $otpRecord = Otp::where('identifier', $data['email'])->first();

    if (!$otpRecord || $otpRecord->otp_code !== $request->otp || now()->gt($otpRecord->expires_at)) {
        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'phone'    => $data['phone'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);

    Session::forget('registration_data');
    $otpRecord->delete();

    return redirect()->route('user#homePage')->with('success', 'Account created successfully!');
}
}

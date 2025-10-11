<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\Otp;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // return view('auth.register');
        return view('authentication.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name'                  => ['required', 'string', 'max:255'],
    //         'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    //         'password'              => ['required', Rules\Password::defaults()],
    //         'password_confirmation' => ['required', 'same:password'],
    //         'phone'                 => 'required',
    //     ]);

    //     $user = User::create([
    //         'name'     => $request->name,
    //         'email'    => $request->email,
    //         'password' => Hash::make($request->password),
    //         'phone'    => $request->phone,
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     // return redirect(route('dashboard', absolute: false));
    //     return to_route('user#homePage');
    // }
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name'                  => ['required', 'string', 'max:255'],
        'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255'],
        'password'              => ['required', Rules\Password::defaults()],
        'password_confirmation' => ['required', 'same:password'],
        'phone'                 => ['required'],
    ]);

    if (User::where('email', $request->email)->exists()) {
        return back()->withErrors(['email' => 'Email is already registered.']);
    }

    Session::put('registration_data', $request->only([
        'name', 'email', 'password', 'phone'
    ]));

    $otp = rand(100000, 999999);

    Otp::updateOrCreate(
        ['identifier' => $request->email],
        [
            'otp_code'    => $otp,
            'expires_at'  => Carbon::now()->addMinutes(10),
        ]
    );

    Mail::to($request->email)->send(new SendOtpMail($otp));

    return redirect()->route('verify.otp.form')->with('status', 'OTP has been sent to your email.');
}
}

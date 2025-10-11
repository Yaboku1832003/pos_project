<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\OtpController;
require_once __DIR__.'/admin.php';
require_once __DIR__.'/user.php';
require __DIR__.'/auth.php';

Route::redirect('/','login');

Route::get('/dashboard', function () {
    return view('authentication.login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// Social Login

//{provider} catch with what social login u logged in
Route::get('/auth/{provider}/redirect',[SocialLoginController::class,'redirect'])->name('socialLogin');
Route::get('/auth/{provider}/callback',[SocialLoginController::class,'callback'])->name('socialCallback');
// Route::post('/webhook/github', [WebhookController::class, 'handleGitHub']);

Route::get('/verify-otp', [OtpController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify.otp.submit');
Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('otp.resend');


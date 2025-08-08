<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    public function changePassword(Request $request)
    {
        $userOriginalPassword = Auth::user()->password; // password from register (necessary)

        // $data = User::where('id',Auth::user( )->id)->first(); // password cant be get in this way
        // dd($data->toArray());

        if (Hash::check($request->oldPassword, $userOriginalPassword)) {
            $this->checkPasswordValidation($request);
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            Alert::success('Process Successed', 'Passsword has been changed');


            //auto logout after changing password
            Auth::logout();
            //session clear
            $request->session()->invalidate();
            $request->session()->regenerateToken();


            //from web.php -> redirect to login page
            return redirect('/');
        } else {
            Alert::error('Process Fail...', 'Old password does not match our records');
            return back();
        }

    }

    //password validation
    //old password = password
    //all must be fill
    //min 6 : max 12
    //new password = confirm password

    private function checkpasswordValidation($request)
    {
        $rules = [
            'oldPassword'     => 'required',
            'newPassword'     => 'required|min:6|max:12|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).+$/',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ];

        $message = [
            'oldPassword.required'     => 'Please enter your current password.',
            'newPassword.required'     => 'Please enter a new password.',
            'newPassword.min'          => 'New password must be at least 6 characters.',
            'newPassword.max'          => 'New password cannot be more than 12 characters.',
            'newPassword.regex'        => 'Password must contain at least one digit, one lowercase letter, one uppercase letter, and one special character (!@#$%^&*()).',
            'confirmPassword.required' => 'Please confirm your new password.',
            'confirmPassword.min'      => 'Confirm password must be at least 6 characters.',
            'confirmPassword.max'      => 'Confirm password cannot be more than 12 characters.',
            'confirmPassword.same'     => 'Confirm password must match the new password.',
        ];

        $request->validate($rules, $message);
    }
}

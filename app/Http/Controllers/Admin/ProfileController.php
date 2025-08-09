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

    //profile edit page
    public function editProfile()
    {
        return view('admin.profile.editProfile');
    }
    //profile update
    public function updateProfile(Request $request)
    {
        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if ($request->hasFile('image')) {
            if (Auth::user()->profile != null) {
                //not first time upload
                $oldImagePath = public_path('profileImage/' . Auth::user()->profile);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/profileImage/', $fileName);
            $data['profile'] = $fileName;
        } else {
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id', Auth::user()->id)->update($data);
        Alert::success('Success Title', 'Profile Updated Successfully');
        return back();
    }

    //change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    //change password
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

        $messages = [
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

        $request->validate($rules, $messages);
    }

    //profile validationCheck
    private function checkProfileValidation($request)
    {
        $rules = [
            'name'    => 'required',
            'email'   => 'required|unique:users,email,' . Auth::user()->id,
            'phone'   => 'required',
            'address' => 'max:200',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'name.required'    => 'Please enter your name.',
            'email.required'   => 'Email is required.',
            'email.unique'     => 'This email is already taken.',
            'phone.required'   => 'Phone number is required.',
            'address.required' => 'Address is required.',
            'image.image'      => 'The file must be an image.',
            'image.mimes'      => 'Allowed image types: jpeg, png, jpg, gif, svg.',
            'image.max'        => 'Image size must not exceed 2MB.',
        ];

        $request->validate($rules, $messages);
    }

    //get profile data
    private function getProfileData($request)
    {
        return [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];
    }

}

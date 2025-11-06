<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $get_current_user = User::find(auth()->user()->id);
        return view('admin/user_profile', compact('get_current_user'));
    }

    public function update_user(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email:rfc,dns',
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ], [
            'full_name.required' => 'Name should not be blank',
            'email.required' => 'Email should not be blank',
            'email.email' => 'Please enter a valid email address',
            'current_password.required' => 'Please enter current password',
            'password.required' => 'Password should not be blank',
            'password.min' => 'Password length must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
            'password_confirmation.required' => 'Please re-enter your password',
            'password_confirmation.min' => 'Password length must be at least 8 characters',
        ]);

        $full_name = trim($request->input('full_name'));
        $password = trim($request->input('password'));
        $current_password = $request->input('current_password');

        $user_data = User::find(auth()->user()->id);
        if(password_verify($current_password, $user_data->password)) {
            $user_data->name = $full_name;
            $user_data->password = Hash::make($password);
            if ($user_data->save())
                return back()->with('success', 'Profile Updated Successfully');
            else
                return back()->withErrors('Error Occurred');
        }
        else
        {
            return back()->with('current_password', 'Current Password is not correct!');
        }
    }
}

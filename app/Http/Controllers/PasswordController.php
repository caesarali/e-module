<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Hash;
use Validator;

class PasswordController extends Controller
{
	public function __construct()
    {
        $this->middleware('admin');
    }

    public function update()
    {
    	Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, \Auth::user()->password);
        });
 
        // message for custom validation
        $messages = [
            'password' => 'Password salah',
        ];
 
        // validate form
        $validator = Validator::make(request()->all(), [
            'current_password'      => 'required|password',
            'password'              => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
 
        ], $messages);
 
        // if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }
 
        // update password
        $user = User::find(Auth::id());
 
        $user->password = bcrypt(request('password'));
        $user->save();
 
        return redirect()
            ->route('profile.index')
            ->with('success-password', 'Password berhasil diperbarui.');
    }

    public function updateEmail()
    {
    	$messages = [
            'email' => 'Email tidak valid.',
        ];

    	$validator = Validator::make(request()->all(), [
            'email'      => 'required|email|string'
        ], $messages);
 
        // if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }

        $user = User::find(Auth::id());
 
        $user->email = request('email');
        $user->save();
 
        return redirect()
            ->route('profile.index')
            ->with('success-email', 'Email berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function viewLogin() {
    	if(\Auth::check()){
			return redirect('/dashboard');
		}

        return view('login');
    }

  	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();

			// Paksa redirect ke dashboard
			return redirect('/dashboard');
		}

		return back()->withErrors([
			'email' => 'Email atau password salah.',
		]);
	}



    public function logout(Request $request)
    {

	    if(\Auth::check())
	    {
	        \Auth::logout();
	        $request->session()->invalidate();
	    }
	    return  redirect('/login');
    }

	public function dashboard() {
		
		return view('dashboard');
	}

	public function checkUser(Request $request)
	{
		$request->validate([
			'email' => 'required|email|exists:users,email',
		],[
			'email.exists' => 'Email tidak valid. Silakan coba lagi.',
		]);

		$user = User::where('email', $request->email)->first();

		return redirect()->route('manual.password.reset', ['user' => $user->id]);
	}

	public function showResetForm($userId)
	{
		$user = User::findOrFail($userId);
		return view('reset-password', compact('user'));
	}


}

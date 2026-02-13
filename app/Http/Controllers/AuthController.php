<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $cred = $request->only('email','password');

    if (Auth::attempt($cred)) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin/aspirasi');
        }

        if ($user->siswa) {
            return redirect('/aspirasi/create');
        }

        Auth::logout();
        return back()->withErrors(['email' => 'Akun tidak valid']);
    }

    return back()->withErrors(['email' => 'Login gagal']);
}

}
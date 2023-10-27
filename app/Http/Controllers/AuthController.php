<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);

            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials, $request->remember)) {
                throw new \Exception('Login Gagal, Username/Password salah');
            }

            $request->session()->regenerate();
            return redirect()->intended('/');
        } catch (\Exception $e) {
            return back()->with('login-error', $e->getMessage());
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required',
                'name' => 'required',
                'password' => 'required'
            ]);

            User::create([
                'email'     => $request->email,
                'name'      => $request->name,
                'password'  => Hash::make($request->password)
            ]);

            return redirect()->route('login')->with('login-info', 'Register Berhasil, Silahkan Login');
        } catch (\Exception $e) {
            return back()->with('register-error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

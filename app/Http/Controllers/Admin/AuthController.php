<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            if (!Auth::guard('admin')->attempt($credentials, $request->remember)) {
                throw new \Exception('Login Gagal, Username/Password salah');
            }

            $request->session()->regenerate();
            return redirect()->intended()->route('dashboard.index');
        } catch (\Exception $e) {
            return back()->with('login-error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

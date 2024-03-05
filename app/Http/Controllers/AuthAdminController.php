<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Event;

class AuthAdminController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->get();
        return view('auth.admin.login', ['events' => $events]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'event' => 'required',
        ], [
            'email.required' => 'Email atau No HP wajib diisi',
            'password.required' => 'Password wajib diisi',
            'event.required' => 'Event wajib diisi',
        ]);

        try {
            $user = User::where('email', $request->email)->orWhere('no_hp', $request->email)->first();

            if(!$user){
                throw new \Exception('Login Gagal, Username/Password salah');
            }

            if($request->event === 'manage-event'){
                if(!User::role('admin')->where('email', $user->email)->first()){
                    throw new \Exception('Login Gagal, Manage Event Hanya untuk Admin');
                }
            } else {
                if((int)$user->event_id !== (int)$request->event){
                    throw new \Exception('Login Gagal, Event yang dipilih tidak sesuai');
                }
            }

            // $credentials = $request->only('email', 'password');
            $credentials = [
                'email' => $user->email,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials, $request->remember)) {
                throw new \Exception('Login Gagal, Username/Password salah');
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return back()->with('login-error', $e->getMessage());
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

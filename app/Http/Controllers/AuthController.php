<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials, $request->remember)) {
                throw new \Exception('Login Gagal, Username/Password salah');
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
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
        $request->validate([
            'email' => 'required|unique:users,email',
            'name' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'name.required' => 'Nama wajib diisi',
            'password.required' => 'Password wajib diisi',
            'email.unique' => 'Email sudah digunakan'
        ]);

        try {

            $user = User::create([
                'email'     => $request->email,
                'name'      => $request->name,
                'password'  => Hash::make($request->password)
            ]);

            // $permissions = Permission::whereIn('name', ['regisrations.index', 'dashboard.index'])->get();
            $permissions = Permission::all();
            $role = Role::where('name', 'user')->first();
            $role->syncPermissions($permissions);
            $user->assignRole($role);

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

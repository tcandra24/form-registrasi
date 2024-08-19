<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->when(request()->search, function($query){
            $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
        })
        ->when(request()->role, function($query){
            $query->whereRelation('roles', 'id', request()->role);
        })
        ->paginate(10);
        $roles = Role::all();

        return view('admin.settings.users.index', [ 'users' => $users, 'roles' => $roles ]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.settings.users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => '',
            ]);

            $roles = Role::whereIn('id', $request->roles)->first();
            $user->assignRole($roles);

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.settings.users.edit', [ 'user' => $user, 'roles' => $roles ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'roles' => 'required',
            'password' => 'nullable',
        ]);

        try {
            $isDisplay = (int)$request->is_display;

            if($request->password == '') {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_hp' => '',
                    'is_display' => $isDisplay,
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'no_hp' => '',
                    'is_display' => $isDisplay,
                ]);
            }

            $roles = Role::whereIn('id', $request->roles)->first();
            $user->syncRoles($roles);

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

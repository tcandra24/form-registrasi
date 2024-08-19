<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);

        return view('admin.settings.permissions.index', [ 'permissions' => $permissions ]);
    }

    public function create()
    {
        return view('admin.settings.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'guard_name.required' => 'Guard name wajib diisi',
        ]);

        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            return redirect()->route('permissions.index')->with('success', 'Pengguna berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

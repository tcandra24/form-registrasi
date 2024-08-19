<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manufacture;

class ManufactureController extends Controller
{
    public function index()
    {
        $manufactures = Manufacture::paginate(10);
        return view('admin.masters.manufactures.index', ['manufactures' => $manufactures]);
    }

    public function create()
    {
        return view('admin.masters.manufactures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi'
        ]);

        try {
            Manufacture::create([
                'name' => $request->name
            ]);

            return redirect()->route('manufactures.index')->with('success', 'Pabrikan Motor Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Manufacture $manufacture)
    {
        try {
            return view('admin.masters.manufactures.edit', ['manufacture' => $manufacture]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Manufacture $manufacture)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi'
        ]);

        try {
            $isActive = $request->active ? true : false;

            $manufacture->update([
                'name' => $request->name,
                'is_active' => $isActive,
            ]);

            return redirect()->route('manufactures.index')->with('success', 'Pabrikan Motor Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $manufacture = Manufacture::findOrFail($id);
            $manufacture->delete();

            return redirect()->route('manufactures.index')->with('success', 'Pekerjaan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

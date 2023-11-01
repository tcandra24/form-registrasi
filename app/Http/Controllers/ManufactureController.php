<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manufacture;

class ManufactureController extends Controller
{
    public function index()
    {
        $manufactures = Manufacture::all();
        return view('manufactures.index', ['manufactures' => $manufactures]);
    }

    public function create()
    {
        return view('manufactures.create');
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

            return redirect()->to('/manufactures')->with('success', 'Pabrikan Motor Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Manufacture $manufacture)
    {
        try {
            return view('manufactures.edit', ['manufacture' => $manufacture]);
        } catch (\Exception $e) {
            return redirect()->to('/manufactures')->with('error', $e->getMessage());
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
            $manufacture->update([
                'name' => $request->name
            ]);

            return redirect()->to('/manufactures')->with('success', 'Pabrikan Motor Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $manufacture = Manufacture::findOrFail($id);
            $manufacture->delete();

            return redirect()->to('/manufactures')->with('success', 'Pekerjaan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/manufactures')->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('services.index', ['services' => $services]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'description.required' => 'Keterangan wajib diisi',
        ]);

        try {
            Service::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->to('/services')->with('success', 'Jasa Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        try {
            return view('services.edit', ['service' => $service]);
        } catch (\Exception $e) {
            return redirect()->to('/services')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'description.required' => 'Keterangan wajib diisi',
        ]);

        try {
            $service->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->to('/services')->with('success', 'Jasa Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return redirect()->to('/services')->with('success', 'Jasa Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/services')->with('error', $e->getMessage());
        }
    }
}

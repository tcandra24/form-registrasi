<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Models\Shift;

class ShiftController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:shifts.index']);
    // }

    public function index()
    {
        $shifts = Shift::withCount('registration')->get();
        return view('shifts.index', ['shifts' => $shifts]);
    }

    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'quota' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi',
            'start.required' => 'Awal wajib diisi',
            'end.required' => 'Akhir wajib diisi',
            'quota.required' => 'Kuota wajib diisi',
        ]);

        try {

            Shift::create([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                'quota' => $request->quota,
            ]);

            return redirect()->to('/shifts')->with('success', 'Shift Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Shift $shift)
    {
        try {
            return view('shifts.edit', ['shift' => $shift]);
        } catch (\Exception $e) {
            return redirect()->to('/shifts')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'quota' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi',
            'start.required' => 'Awal wajib diisi',
            'end.required' => 'Akhir wajib diisi',
            'quota.required' => 'Kuota wajib diisi',
        ]);

        try {
            $shift->update([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                'quota' => $request->quota,
            ]);

            return redirect()->to('/shifts')->with('success', 'Shift Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $shift = Shift::findOrFail($id);
            $shift->delete();

            return redirect()->to('/shifts')->with('success', 'Shift Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/shifts')->with('error', $e->getMessage());
        }
    }
}

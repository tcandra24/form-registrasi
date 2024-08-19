<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shift;
use App\Models\Event;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::with('event')->withCount('registration')->paginate(10);
        return view('admin.masters.shifts.index', ['shifts' => $shifts]);
    }

    public function create()
    {
        $events = Event::where('is_active', true)->get();
        return view('admin.masters.shifts.create', [ 'events' => $events ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'quota' => 'required',
            'event_id' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi',
            'start.required' => 'Awal wajib diisi',
            'end.required' => 'Akhir wajib diisi',
            'quota.required' => 'Kuota wajib diisi',
            'event_id.required' => 'Event wajib diisi'
        ]);

        try {

            Shift::create([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                'quota' => $request->quota,
                'event_id' => $request->event_id
            ]);

            return redirect()->route('shifts.index')->with('success', 'Shift Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Shift $shift)
    {
        try {
            $events = Event::where('is_active', true)->get();

            return view('admin.masters.shifts.edit', [ 'shift' => $shift, 'events' => $events ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Shift $shift)
    {
        $request->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
            'quota' => 'required',
            'event_id' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi',
            'start.required' => 'Awal wajib diisi',
            'end.required' => 'Akhir wajib diisi',
            'quota.required' => 'Kuota wajib diisi',
            'event_id.required' => 'Event wajib diisi'
        ]);

        try {
            $isActive = $request->active ? true : false;

            $shift->update([
                'name' => $request->name,
                'start' => $request->start,
                'end' => $request->end,
                'quota' => $request->quota,
                'is_active' => $isActive,
                'event_id' => $request->event_id
            ]);

            return redirect()->route('shifts.index')->with('success', 'Shift Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $shift = Shift::findOrFail($id);
            $shift->delete();

            return redirect()->route('shifts.index')->with('success', 'Shift Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

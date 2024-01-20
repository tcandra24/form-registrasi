<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('events.index', ['events' => $events]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'description.required' => 'Keterangan wajib diisi',
            'image.required' => 'Gambar wajib diisi',
        ]);

        try {
            $image = $request->file('image');
            $image->storeAs('public/images/events', $image->hashName());

            Event::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $image->hashName(),
                'link' => $request->link,
                'slug' => Str::slug($request->name),
            ]);

            return redirect()->to('/events')->with('success', 'Event Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function edit(Event $event)
    {
        try {
            return view('events.edit', ['event' => $event]);
        } catch (\Exception $e) {
            return redirect()->to('/events')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'description.required' => 'Keterangan wajib diisi',
            'image.required' => 'Gambar wajib diisi',
        ]);

        try {
            $isActive = $request->is_active ? true : false;

            if($request->file('image')) {
                if(Storage::disk('local')->exists('public/images/events/'. basename($event->name))){
                    Storage::disk('local')->delete('public/images/events/'. basename($event->image));
                }

                $image = $request->file('image');
                $image->storeAs('public/images/events', $image->hashName());


                $event->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'image' => $image->hashName(),
                    'is_active' => $isActive,
                    'link' => $request->link,
                    'slug' => Str::slug($request->name),
                ]);
            } else {
                $event->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'is_active' => $isActive,
                    'link' => $request->link,
                    'slug' => Str::slug($request->name),
                ]);
            }

            return redirect()->to('/events')->with('success', 'Event Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            if(Storage::disk('local')->exists('public/images/events/'. basename($event->name))){
                Storage::disk('local')->delete('public/images/events/'. basename($event->image));
            }

            return redirect()->to('/events')->with('success', 'Event Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/events')->with('error', $e->getMessage());
        }
    }
}

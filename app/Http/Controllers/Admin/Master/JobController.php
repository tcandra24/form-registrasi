<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::paginate(10);
        return view('admin.masters.jobs.index', ['jobs' => $jobs]);
    }

    public function create()
    {
        return view('admin.masters.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi'
        ]);

        try {
            Job::create([
                'name' => $request->name
            ]);

            return redirect()->route('jobs.index')->with('success', 'Pekerjaan Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Job $job)
    {
        try {
            return view('admin.masters.jobs.edit', ['job' => $job]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'Nama wajib diisi'
        ]);

        try {
            $isActive = $request->active ? true : false;

            $job->update([
                'name' => $request->name,
                'is_active' => $isActive,
            ]);

            return redirect()->route('jobs.index')->with('success', 'Pekerjaan Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->delete();

            return redirect()->route('jobs.index')->with('success', 'Pekerjaan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

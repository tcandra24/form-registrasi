<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:jobs.index']);
    // }

    public function index()
    {
        $jobs = Job::all();
        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create()
    {
        return view('jobs.create');
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

            return redirect()->to('/jobs')->with('success', 'Pekerjaan Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Job $job)
    {
        try {
            return view('jobs.edit', ['job' => $job]);
        } catch (\Exception $e) {
            return redirect()->to('/jobs')->with('error', $e->getMessage());
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
            $job->update([
                'name' => $request->name
            ]);

            return redirect()->to('/jobs')->with('success', 'Pekerjaan Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $job = Job::findOrFail($id);
            $job->delete();

            return redirect()->to('/jobs')->with('success', 'Pekerjaan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/jobs')->with('error', $e->getMessage());
        }
    }
}

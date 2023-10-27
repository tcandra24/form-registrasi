<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Job;
use App\Models\Shift;
use App\Models\Registration AS RegistrationModel;

class RegistrationController extends Controller
{
    public function index() {
        $jobs = Job::all();
        $shifts = Shift::all();

        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();
        if($registration) {

            return view('registrations.index', [ 'registration' => $registration]);
        }

        return view('registrations.index', [ 'jobs' => $jobs, 'shifts' => $shifts]);
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'fullname' => 'required',
                'no_hp' => 'required',
                'vehicle_type' => 'required',
                'license_plate' => 'required',
                'job' => 'required',
                'shift' => 'required',
            ]);

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . Auth::user()->name), Auth::user()->id . Auth::user()->name);

            RegistrationModel::create([
                'fullname' => $request->fullname,
                'no_hp' => $request->no_hp,
                'vehicle_type' => $request->vehicle_type,
                'license_plate' => $request->license_plate,
                'job_id' => $request->job,
                'shift_id' => $request->shift,
                'user_id' => Auth::user()->id,
                'token' => $token
            ]);

            return redirect()->to('/registrations')->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

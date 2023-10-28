<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Job;
use App\Models\Shift;
use App\Models\Registration AS RegistrationModel;

class RegistrationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['role:user', 'permission:registrations.index']);
    // }

    public function index()
    {
        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();

        if($registration) {
            return view('registrations.index', [ 'registration' => $registration]);
        }

        $jobs = Job::all();
        $shifts = Shift::withCount('registration')->get();

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

            $shift = Shift::select('quota')->withCount('registration')->where('id', $request->shift)->first();
            if(($shift->quota - $shift->registration_count) === 0){
                return redirect()->to('/registrations')->with('error', 'Kuota shift sudah penuh');
            }

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . Auth::user()->name), Auth::user()->id . Auth::user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('/public/qr-codes/') . 'qr-code-' . $token . '.svg');

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

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
use App\Models\Manufacture;
use App\Models\Service;
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

        $jobs = Job::where('is_active', 1)->get();
        $services = Service::all();
        $shifts = Shift::where('is_active', 1)->withCount('registration')->get();
        $manufactures = Manufacture::all();

        return view('registrations.index', [
            'jobs' => $jobs,
            'shifts' => $shifts,
            'manufactures' => $manufactures,
            'services' => $services
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'no_hp' => 'required',
            'vehicle_type' => 'required',
            'license_plate' => 'required',
            'job' => 'required',
            'shift' => 'required',
            'manufacture' => 'required',
            'services' => 'required',
        ], [
            'fullname.required' => 'Nama Lengkap wajib diisi',
            'no_hp.required' => 'Nomer HP wajib diisi',
            'vehicle_type.required' => 'Tipe Kendaraan wajib diisi',
            'license_plate.required' => 'Plat Nomor wajib diisi',
            'job.required' => 'Pekerjaan wajib diisi',
            'shift.required' => 'Shift wajib diisi',
            'manufacture.required' => 'Pabrikan Motor wajib diisi',
            'services.required' => 'Jasa Motor wajib diisi',
        ]);

        try {
            $shift = Shift::select('quota')->withCount('registration')->where('id', $request->shift)->first();
            if(($shift->quota - $shift->registration_count) === 0){
                return redirect()->to('/registrations')->with('error', 'Kuota shift sudah penuh');
            }

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . Auth::user()->name), Auth::user()->id . Auth::user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = RegistrationModel::withTrashed()->max('registration_number') + 1;
            $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            $registration = RegistrationModel::create([
                'fullname' => $request->fullname,
                'registration_number' => $registration_number,
                'no_hp' => $request->no_hp,
                'vehicle_type' => $request->vehicle_type,
                'license_plate' => $request->license_plate,
                'job_id' => $request->job,
                'shift_id' => $request->shift,
                'user_id' => Auth::user()->id,
                'manufacture_id' => $request->manufacture,
                'token' => $token
            ]);

            $services = Service::select('id')->whereIn('id', $request->services)->get();

            $registration->services()->attach($services);

            return redirect()->to('/registrations')->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

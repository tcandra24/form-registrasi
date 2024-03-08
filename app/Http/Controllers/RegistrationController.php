<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RegistrationImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Registration AS RegistrationModel;
use App\Models\Job;
use App\Models\Shift;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RegistrationController extends Controller
{
    public function index()
    {
        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();

        if($registration) {
            return view('registrations.index', [ 'registration' => $registration]);
        }

        $jobs = Job::where('is_active', true)->get();
        $shift = Shift::select('id')->first();

        return view('registrations.index', [
            'jobs' => $jobs,
            'shift' => $shift,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'no_hp' => 'required',
            'vehicle_type' => 'required',
            'license_plate' => 'required',
            'job' => 'required',
            'date_birth' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'bood_type' => 'required',
        ], [
            'fullname.required' => 'Nama Lengkap wajib diisi',
            'no_hp.required' => 'Nomer HP wajib diisi',
            'vehicle_type.required' => 'Tipe Kendaraan wajib diisi',
            'license_plate.required' => 'Plat Nomor wajib diisi',
            'job.required' => 'Pekerjaan wajib diisi',
            'date_birth.required' => 'Tanggal Lahir wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'gender.required' => 'Jenis Kelaminr wajib diisi',
            'bood_type.required' => 'Tipe Darah wajib diisi',
        ]);

        try {
            $shift = Shift::select('quota')->withCount('registration')->where('id', $request->shift)->first();
            if(($shift->quota - $shift->registration_count) === 0){
                return redirect()->to('/registrations')->with('error', 'Kuota shift sudah penuh');
            }

            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . Auth::user()->name), Auth::user()->id . Auth::user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = RegistrationModel::withTrashed()->where('event_slug', Auth::user()->event->slug)->max('registration_number') + 1;
            $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            RegistrationModel::create([
                'fullname' => $request->fullname,
                'date_birth' => Carbon::parse($request->date_birth)->format('Y-m-d'),
                'address' => $request->address,
                'gender' => $request->gender,
                'bood_type' => $request->bood_type,
                'registration_number' => $registration_number,
                'no_hp' => $request->no_hp,
                'vehicle_type' => $request->vehicle_type,
                'license_plate' => $request->license_plate,
                'job_id' => $request->job,
                'shift_id' => $request->shift,
                'user_id' => Auth::user()->id,
                'event_slug' => Auth::user()->event->slug,
                'token' => $token
            ]);

            return redirect()->to('/registrations')->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function import()
    {
        return view('registrations.import');
    }

    public function saveImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            Excel::import(new RegistrationImport, $file);

            return redirect()->to('/registrations/import')->with('success', 'Import Berhasil Dilakukan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // public function loginFromLink(Request $request)
    // {
    //     $registration = RegistrationModel::where('token', $request->token);
    //     if(!$registration->exists()){
    //         abort(404);
    //     }

    //     $credentials = [
    //         'email' => $registration->email,
    //         'password' => 123456789,
    //     ];

    //     Auth::attempt($credentials, true);

    //     $request->session()->regenerate();
    //     return redirect()->intended('/dashboard');
    // }
}

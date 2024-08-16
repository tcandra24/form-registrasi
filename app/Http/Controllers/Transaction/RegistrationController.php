<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Registration;
use App\Models\Shift;
use App\Models\Job;
use App\Models\Manufacture;
use App\Models\Service;

class RegistrationController extends Controller
{
    public function index($event)
    {
        $registrations = Registration::when(request()->search, function($query){
            if (request()->filter === 'email') {
                $query->whereRelation('user', 'name', 'LIKE', '%' . request()->search . '%');
            } else {
                $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
            }
        })
        ->when(request()->scan, function($query){
            $query->where('is_scan', request()->scan == 'true' ? true : false);
        })
        ->when(request()->shift, function($query){
            $query->where('shift_id', request()->shift);
        })
        ->where('event_slug', $event)->where('fullname', '<>', '')->paginate(10);
        $shifts = Shift::all();

        return view('transactions.registration.index', [
            'registrations' => $registrations,
            'shifts' => $shifts
        ]);
    }

    public function create()
    {
        $jobs = Job::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $shifts = Shift::where('is_active', true)->withCount('registration')->get();
        $manufactures = Manufacture::where('is_active', true)->get();

        return view('transactions.registration.create', [
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
            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . auth()->user()->name), auth()->user()->id . auth()->user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = Registration::withTrashed()->where('event_slug', $request->event)->max('registration_number') + 1;
            $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            $isVip = (int)$request->is_vip;

            $registration = Registration::create([
                'fullname' => $request->fullname,
                'registration_number' => $registration_number,
                'no_hp' => $request->no_hp,
                'vehicle_type' => $request->vehicle_type,
                'license_plate' => $request->license_plate,
                'job_id' => $request->job,
                'shift_id' => $request->shift,
                'user_id' => 0,
                'manufacture_id' => $request->manufacture,
                'event_slug' => $request->event,
                'is_vip' => $isVip,
                'is_scan' => true,
                'token' => $token
            ]);

            $services = Service::select('id')->whereIn('id', $request->services)->get();

            $registration->services()->attach($services);

            return redirect()->to('/transactions/registration-mechanics/' . request()->event)->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($event, $id)
    {
        $registration = Registration::where('event_slug', $event)->where('id', $id)->first();
        return view('transactions.registration.show', [ 'registration' => $registration]);
    }

    public function destroy($event, $id)
    {
        try {
            $registration = Registration::where('event_slug', $event)->where('id', $id);
            $registration->delete();

            return redirect()->to('/transactions/registrations/' . $event)->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations/' . $event)->with('error', $e->getMessage());
        }
    }

    public function destroyAllNotScan($event)
    {
        try {
            $registration = Registration::where('event_slug', $event)->where('is_scan', false);
            $registration->delete();

            return redirect()->to('/transactions/registrations/' . $event)->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations/' . $event)->with('error', $e->getMessage());
        }
    }

    public function updateIsScan($event, $id)
    {
        try {
            Registration::where('event_slug', $event)->where('id', $id)->update([
                'is_scan' => true,
                'scan_date' => Carbon::now(),
            ]);

            return redirect()->to('/transactions/registrations/' . $event)->with('success', 'Data Registrasi Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations/' . $event)->with('error', $e->getMessage());
        }
    }
}

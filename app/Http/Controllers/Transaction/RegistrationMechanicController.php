<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\UpdateRegisterData;

use App\Models\RegistrationMechanic;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RegistrationMechanicImport;

class RegistrationMechanicController extends Controller
{
    public function index($event)
    {
        $registrations = RegistrationMechanic::when(request()->search, function($query){
            if (request()->filter === 'email') {
                $query->whereRelation('user', 'name', 'LIKE', '%' . request()->search . '%');
            } else {
                $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
            }
        })
        ->when(request()->scan, function($query){
            $query->where('is_scan', request()->scan == 'true' ? true : false);
        })
        ->where('event_slug', $event)->where('fullname', '<>', '')->paginate(10);

        return view('transactions.registration_mechanic.index', [
            'registrations' => $registrations
        ]);
    }

    public function create()
    {
        return view('transactions.registration_mechanic.create');
    }

    public function store(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'no_hp' => 'required',
            'workshop_name' => 'required',
            'address' => 'required',
        ], [
            'fullname.required' => 'Nama Lengkap wajib diisi',
            'no_hp.required' => 'Nomer HP wajib diisi',
            'workshop_name.required' => 'Nama Bengkel wajib diisi',
            'address.required' => 'Alamat wajib diisi',
        ]);

        try {
            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . auth()->user()->name), auth()->user()->id . auth()->user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = RegistrationMechanic::withTrashed()->where('event_slug', $request->event)->max('registration_number') + 1;
            $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            $isVip = (int)$request->is_vip;

            $registration = RegistrationMechanic::create([
                'fullname' => $request->fullname,
                'registration_number' => $registration_number,
                'no_hp' => $request->no_hp,
                'workshop_name' => $request->workshop_name,
                'address' => $request->address,
                'user_id' => 0, // Di set 0 karena diinput manual oleh admin, jadi tidak bisa login dan qrcode tetap tampil
                'event_slug' => $request->event,
                'is_vip' => $isVip,
                'is_scan' => true, // Diset true karena daftar manual ditempat dan tidak perlu scan
                'token' => $token
            ]);

            event(new UpdateRegisterData('input-manual', $registration));

            return redirect()->to('/transactions/registration-mechanics/' . request()->event)->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($event, $id)
    {
        $registration = RegistrationMechanic::where('event_slug', $event)->where('id', $id)->first();
        return view('transactions.registration_mechanic.show', [ 'registration' => $registration]);
    }

    public function destroy($event, $id)
    {
        try {
            $registration = RegistrationMechanic::where('event_slug', $event)->where('id', $id);
            $registration->delete();

            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('error', $e->getMessage());
        }
    }

    public function destroyAllNotScan($event)
    {
        try {
            $registration = RegistrationMechanic::where('event_slug', $event)->where('is_scan', false);
            $registration->delete();

            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('error', $e->getMessage());
        }
    }

    public function import()
    {
        return view('transactions.registration_mechanic.import');
    }

    public function doImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            Excel::import(new RegistrationMechanicImport, $file);

            return redirect()->to('/transactions/registration-mechanics/'. request()->event . '/import')->with('success', 'Import Berhasil Dilakukan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateIsScan($event, $id)
    {
        try {
            RegistrationMechanic::where('event_slug', $event)->where('id', $id)->update([
                'is_scan' => true,
                'scan_date' => Carbon::now(),
                'updated_by' => auth()->user()->id,
            ]);

            $registration = RegistrationMechanic::where('event_slug', $event)->where('id', $id)->first();

            event(new UpdateRegisterData('change-status-manual', $registration));

            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('success', 'Data Registrasi Berhasil Diubah');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registration-mechanics/' . $event)->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\RegistrationMechanic;

class RegistrationMechanicsController extends Controller
{
    public function index()
    {
        $registration = RegistrationMechanic::where('user_id', Auth::user()->id)->first();

        if($registration) {
            return view('registration_mechanics.index', [ 'registration' => $registration]);
        }

        return view('registration_mechanics.index');
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
            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . Auth::user()->name), Auth::user()->id . Auth::user()->name);

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = RegistrationMechanic::withTrashed()->where('event_slug', Auth::user()->event->slug)->max('registration_number') + 1;
            $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            RegistrationMechanic::create([
                'fullname' => $request->fullname,
                'registration_number' => $registration_number,
                'no_hp' => $request->no_hp,
                'workshop_name' => $request->workshop_name,
                'address' => $request->address,
                'user_id' => Auth::user()->id,
                'event_slug' => Auth::user()->event->slug,
                'token' => $token
            ]);

            return redirect()->to('/registration-mechanics')->with('success', 'Pendaftaran Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

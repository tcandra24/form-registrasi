<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationMechanic;

class RegistrationMechanicController extends Controller
{
    public function index($event)
    {
        $registrations = RegistrationMechanic::where('event_slug', $event)->where('fullname', '<>', '');

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        $registrations = $registrations->paginate(10);

        return view('transactions.registration_mechanic.index', [
            'registrations' => $registrations
        ]);
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
}

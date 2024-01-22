<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationMechanic;

class RegistrationMechanicController extends Controller
{
    public function index()
    {
        $registrations = RegistrationMechanic::where('fullname', '<>', '');

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        $registrations = $registrations->get();

        return view('transactions.registration_mechanic.index', [ 'registrations' => $registrations]);
    }

    public function show($id)
    {
        $registration = RegistrationMechanic::where('id', $id)->first();
        return view('transactions.registration_mechanic.show', [ 'registration' => $registration]);
    }

    public function destroy($id)
    {
        try {
            $registration = RegistrationMechanic::findOrFail($id);
            $registration->delete();

            return redirect()->to('/transactions/registration-mechanics')->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registration-mechanics')->with('error', $e->getMessage());
        }
    }

    public function destroyAllNotScan()
    {
        try {
            $registration = RegistrationMechanic::where('is_scan', false);
            $registration->delete();

            return redirect()->to('/transactions/registration-mechanics')->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registration-mechanics')->with('error', $e->getMessage());
        }
    }
}

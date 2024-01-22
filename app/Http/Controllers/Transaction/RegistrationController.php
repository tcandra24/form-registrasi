<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Shift;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::where('fullname', '<>', '');
        $shifts = Shift::all();

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        if(request()->has('shift') && request('shift') !== '-') {
            $registrations = $registrations->where('shift_id', request('shift'));
        }

        $registrations = $registrations->get();

        return view('transactions.registration.index', [ 'registrations' => $registrations, 'shifts' => $shifts]);
    }

    public function show($id)
    {
        $registration = Registration::where('id', $id)->first();
        return view('transactions.registration.show', [ 'registration' => $registration]);
    }

    public function destroy($id)
    {
        try {
            $registration = Registration::findOrFail($id);
            $registration->delete();

            return redirect()->to('/transactions/registrations')->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations')->with('error', $e->getMessage());
        }
    }

    public function destroyAllNotScan()
    {
        try {
            $registration = Registration::where('is_scan', false);
            $registration->delete();

            return redirect()->to('/transactions/registrations')->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations')->with('error', $e->getMessage());
        }
    }
}

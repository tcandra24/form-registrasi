<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Shift;

class RegistrationController extends Controller
{
    public function index($event)
    {
        $registrations = Registration::where('event_slug', $event)->where('fullname', '<>', '');
        $shifts = Shift::all();

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        if(request()->has('shift') && request('shift') !== '-') {
            $registrations = $registrations->where('shift_id', request('shift'));
        }

        $registrations = $registrations->paginate(10);

        return view('transactions.registration.index', [
            'registrations' => $registrations,
            'shifts' => $shifts
        ]);
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
}

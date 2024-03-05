<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::where('event_slug', $request->event)->where('fullname', '<>', '')->paginate(10);

        return view('transactions.registration.index', [
            'registrations' => $registrations,
            'event_slug' => $request->slug,
        ]);
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

            return redirect()->to('/transactions/registrations/' . $registration->event_slug)->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations')->with('error', $e->getMessage());
        }
    }

    public function destroyAllNotScan(Request $request)
    {
        try {
            $registration = Registration::where('event_slug', $request->event)->where('is_scan', false);
            $registration->delete();

            return redirect()->to('/transactions/registrations')->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations')->with('error', $e->getMessage());
        }
    }
}

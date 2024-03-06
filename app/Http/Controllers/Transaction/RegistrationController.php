<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function index(Request $request)
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
        ->where('event_slug', $request->event)->where('fullname', '<>', '')->paginate(10);

        // if(request()->has('scan') && request('scan') !== '-') {
        //     $registrations = $registrations->where('is_scan', request('scan'));
        // }

        // if(request()->has('shift') && request('shift') !== '-') {
        //     $registrations = $registrations->where('shift_id', request('shift'));
        // }

        // $registrations = $registrations->paginate(10);

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

            return redirect()->to('/transactions/registrations/' . $request->event)->with('success', 'Semua Data Registrasi yang Tidak Scan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations/' . $request->event)->with('error', $e->getMessage());
        }
    }

    public function scanManual($id)
    {
        try {
            $registration = Registration::where('id', $id)->first();
            $registration->update([
                'is_scan' => true,
                'scan_date' => Carbon::now()
            ]);

            return redirect()->to('/transactions/registrations/' . $registration->event_slug)->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->to('/transactions/registrations')->with('error', $e->getMessage());
        }
    }
}

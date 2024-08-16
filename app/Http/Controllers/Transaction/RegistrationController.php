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

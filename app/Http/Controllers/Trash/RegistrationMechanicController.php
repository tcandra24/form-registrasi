<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationMechanic;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationMechanicTrashExport;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;


class RegistrationMechanicController extends Controller
{
    public function index($event)
    {
        $registrations = RegistrationMechanic::onlyTrashed()->where('event_slug', $event)->where('fullname', '<>', '');
        $shifts = Shift::all();

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        $registrations = $registrations->paginate(10);

        return view('trash.registration_mechanic.index', [ 'registrations' => $registrations, 'shifts' => $shifts]);
    }

    public function restore($event, $id)
    {
        try {
            RegistrationMechanic::onlyTrashed()->where('event_slug', $event)->where('id', $id)->restore();

            return redirect()->to('/trash/registration-mechanics')->with('success', 'Data Registrasi Berhasil Dipulihkan');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registration-mechanics')->with('error', $e->getMessage());
        }
    }

    public function destroy($event, $id)
    {
        try {
            DB::transaction(function() use ($id, $event){
                $registration = RegistrationMechanic::onlyTrashed()->where('event_slug', $event)->findOrFail($id);
                $registration->forceDelete();
            });

            return redirect()->to('/trash/registration-mechanics')->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registration-mechanics')->with('error', $e->getMessage());
        }
    }

    public function export(Request $request, $event)
    {
        return Excel::download(new RegistrationMechanicTrashExport($request->is_scan, $event), 'registration-mechanics-deleted.xlsx');
    }
}

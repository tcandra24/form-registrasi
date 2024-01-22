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
    public function index()
    {
        $registrations = RegistrationMechanic::onlyTrashed()->where('fullname', '<>', '');
        $shifts = Shift::all();

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        $registrations = $registrations->get();

        return view('trash.registration_mechanic.index', [ 'registrations' => $registrations, 'shifts' => $shifts]);
    }

    public function restore($id)
    {
        try {
            $registration = RegistrationMechanic::onlyTrashed()->where('id', $id)->first();
            $shift = Shift::select('quota')->withCount(['registration' => function ($query) use ($registration) {
                return $query->where('shift_id', $registration->shift->id);
            }])->where('id', $registration->shift->id)->first();
            $restQuota = (int)$shift->quota - (int)$shift->registration_count;
            if($restQuota < 1) {
                return redirect()->to('/trash/registration-mechanics')->with('error', 'Kuota shift sudah penuh');
            }

            RegistrationMechanic::onlyTrashed()->where('id', $id)->restore();

            return redirect()->to('/trash/registration-mechanics')->with('success', 'Data Registrasi Berhasil Dipulihkan');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registration-mechanics')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function() use ($id){
                $registration = RegistrationMechanic::onlyTrashed()->findOrFail($id);
                $registration->services()->detach();
                $registration->forceDelete();
            });

            return redirect()->to('/trash/registration-mechanics')->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registration-mechanics')->with('error', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new RegistrationMechanicTrashExport($request->is_scan), 'registration-mechanics-deleted.xlsx');
    }
}

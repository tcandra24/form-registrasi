<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationTrashExport;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;


class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::onlyTrashed()->where('fullname', '<>', '');
        $shifts = Shift::all();

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        if(request()->has('shift') && request('shift') !== '-') {
            $registrations = $registrations->where('shift_id', request('shift'));
        }

        $registrations = $registrations->paginate(10);

        return view('trash.registration.index', [ 'registrations' => $registrations, 'shifts' => $shifts]);
    }

    public function restore($id)
    {
        try {
            $registration = Registration::onlyTrashed()->where('id', $id)->first();
            $shift = Shift::select('quota')->withCount(['registration' => function ($query) use ($registration) {
                return $query->where('shift_id', $registration->shift->id);
            }])->where('id', $registration->shift->id)->first();
            $restQuota = (int)$shift->quota - (int)$shift->registration_count;
            if($restQuota < 1) {
                return redirect()->to('/trash/registrationsh')->with('error', 'Kuota shift sudah penuh');
            }

            Registration::onlyTrashed()->where('id', $id)->restore();

            return redirect()->to('/trash/registrations')->with('success', 'Data Registrasi Berhasil Dipulihkan');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registrations')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function() use ($id){
                $registration = Registration::onlyTrashed()->findOrFail($id);
                $registration->services()->detach();
                $registration->forceDelete();
            });

            return redirect()->to('/trash/registrations')->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registrations')->with('error', $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new RegistrationTrashExport($request->shift, $request->is_scan), 'registrations-deleted.xlsx');
    }
}

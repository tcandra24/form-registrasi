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
    public function index(Request $request)
    {
        $registrations = Registration::onlyTrashed()->where('event_slug', $request->event)->where('fullname', '<>', '')->paginate(10);

        return view('trash.registration.index', [ 'registrations' => $registrations]);
    }

    public function restore($id)
    {
        try {
            $registration = Registration::onlyTrashed()->where('id', $id)->first();
            // $shift = Shift::select('quota')->withCount(['registration' => function ($query) use ($registration) {
            //     return $query->where('shift_id', $registration->shift->id);
            // }])->where('id', $registration->shift->id)->first();
            // $restQuota = (int)$shift->quota - (int)$shift->registration_count;
            // if($restQuota < 1) {
            //     return redirect()->to('/trash/registrationsh/' . $registration->event_slug)->with('error', 'Kuota shift sudah penuh');
            // }

            Registration::onlyTrashed()->where('id', $id)->restore();

            return redirect()->to('/trash/registrations/' . $registration->event_slug)->with('success', 'Data Registrasi Berhasil Dipulihkan');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registrations')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $registration = Registration::onlyTrashed()->findOrFail($id);
            $registration->forceDelete();

            return redirect()->to('/trash/registrations/'. $registration->event_slug)->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/trash/registrations')->with('error', $e->getMessage());
        }
    }

    public function export(Request $request, $event)
    {
        return Excel::download(new RegistrationTrashExport($request->scan, $event, $request->search, $request->filter), 'registrations-deleted.xlsx');
    }
}

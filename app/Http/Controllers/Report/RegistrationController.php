<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationExport;
use Illuminate\Http\Request;

use App\Models\Registration;
use App\Models\Shift;

class RegistrationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:report_registrations.index']);
    // }
    // public function data()
    // {
    //     $registrations = Registration::where('name', '<>', '');
    //     return DataTables::of($masterSO)->addIndexColumn()->toJson();
    // }

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

        return view('reports.registration.index', [ 'registrations' => $registrations, 'shifts' => $shifts]);
    }

    public function export(Request $request)
    {
        return Excel::download(new RegistrationExport($request->shift, $request->is_scan), 'registrations.xlsx');
    }
}

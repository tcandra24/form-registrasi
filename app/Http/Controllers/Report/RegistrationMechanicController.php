<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationMechanicExport;
use Illuminate\Http\Request;

use App\Models\RegistrationMechanic;

class RegistrationMechanicController extends Controller
{
    public function index($event)
    {
        $registrations = RegistrationMechanic::where('event_slug', $event)->where('fullname', '<>', '');

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        $registrations = $registrations->paginate(10);

        return view('reports.registration_mechanic.index', [ 'registrations' => $registrations]);
    }

    public function export(Request $request, $event)
    {
        return Excel::download(new RegistrationMechanicExport($request->is_scan, $event), 'registration-mechanics.xlsx');
    }
}

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
        $registrations = RegistrationMechanic::when(request()->search, function($query){
            if (request()->filter === 'email') {
                $query->whereRelation('user', 'name', 'LIKE', '%' . request()->search . '%');
            } else {
                $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
            }
        })
        ->when(request()->scan, function($query){
            $query->where('is_scan', request()->scan == 'true' ? true : false);
        })
        ->where('event_slug', $event)->where('fullname', '<>', '')->paginate(10);

        return view('reports.registration_mechanic.index', [ 'registrations' => $registrations]);
    }

    public function export(Request $request, $event)
    {
        return Excel::download(new RegistrationMechanicExport($request->is_scan, $event, $request->search, $request->filter), 'registration-mechanics.xlsx');
    }
}

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
        })->where('event_slug', $event)->paginate(10);

        return view('reports.registration.index', [ 'registrations' => $registrations]);
    }

    public function export(Request $request, $event)
    {
        return Excel::download(new RegistrationExport($request->scan, $event, $request->search, $request->filter), 'registrations.xlsx');
    }
}

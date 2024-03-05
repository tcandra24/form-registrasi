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
        $registrations = Registration::where('event_slug', $event)->paginate(10);

        return view('reports.registration.index', [ 'registrations' => $registrations]);
    }

    public function export($event)
    {
        return Excel::download(new RegistrationExport($event), 'registrations.xlsx');
    }
}

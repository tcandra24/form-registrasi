<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        $registrations = Registration::all();
        // $shifts = Shift::all();

        return view('reports.registration.index', [ 'registrations' => $registrations]);
    }
}

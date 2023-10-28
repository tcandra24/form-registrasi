<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Registration;

class RegistrationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:report_registrations.index']);
    // }

    public function index()
    {
        $registrations = Registration::all();
        return view('reports.registration.index', [ 'registrations' => $registrations ]);
    }
}

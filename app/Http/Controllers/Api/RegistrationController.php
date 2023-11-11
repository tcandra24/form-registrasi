<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        try {
            if(request()->has('is_scan')){
                $registrations = Registration::with('shift', 'job', 'services', 'user')->where('is_scan', request()->is_scan)->get();
            } else {
                $registrations = Registration::with('shift', 'job', 'services', 'user')->get();
            }

            return response()->json([
                'success' => true,
                'data' => $registrations
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $registration = Registration::with('shift', 'job', 'services', 'user')->where('id', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $registration
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }
}

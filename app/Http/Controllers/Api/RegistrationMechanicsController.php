<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RegistrationMechanic;
use Illuminate\Http\Request;

class RegistrationMechanicsController extends Controller
{
    public function index()
    {
        try {
            if(request()->has('is_scan')){
                $registrations = RegistrationMechanic::with(['shift', 'job', 'services' => function($query) {
                    $query->select('name');
                }, 'user', 'manufacture'])->where('is_scan', request()->is_scan)->get();
            } else {
                $registrations = RegistrationMechanic::with(['shift', 'job', 'services' => function($query) {
                    $query->select('name');
                }, 'user', 'manufacture'])->get();
            }

            $registrations = $registrations->map(function($registration){

                return [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'email' => $registration->user->email,
                    'workshop_name' => $registration->workshop_name,
                    'address' => $registration->address,
                    'mechanics_count' => $registration->mechanics_count,
                    'fullname' => $registration->fullname,
                    'no_hp' => $registration->no_hp,
                    'scan_status' => $registration->is_scan ? 'Sudah Scan' : 'Belum Scan',
                    'scan_date' => $registration->scan_date,
                    'job' => $registration->job->name,
                    'token' => $registration->token
                ];
            });

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
            $registration = RegistrationMechanic::with('shift', 'job', 'services', 'user')->where('id', $id)->get();

            $registration = $registration->map(function($registration){

                return [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'email' => $registration->user->email,
                    'workshop_name' => $registration->workshop_name,
                    'address' => $registration->address,
                    'mechanics_count' => $registration->mechanics_count,
                    'fullname' => $registration->fullname,
                    'no_hp' => $registration->no_hp,
                    'scan_status' => $registration->is_scan ? 'Sudah Scan' : 'Belum Scan',
                    'scan_date' => $registration->scan_date,
                    'job' => $registration->job->name,
                    'token' => $registration->token
                ];
            });

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

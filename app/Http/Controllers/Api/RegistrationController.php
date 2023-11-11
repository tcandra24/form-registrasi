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
                $registrations = Registration::with(['shift', 'job', 'services' => function($query) {
                    $query->select('name');
                }, 'user', 'manufacture'])->where('is_scan', request()->is_scan)->get();
            } else {
                $registrations = Registration::with(['shift', 'job', 'services' => function($query) {
                    $query->select('name');
                }, 'user', 'manufacture'])->get();
            }

            $registrations = $registrations->map(function($registration){

                return [
                    'registration_number' => $registration->registration_number,
                    'email' =>  $registration->user->email,
                    'fullname' => $registration->fullname,
                    'services' => $registration->services,
                    'shift' => \Carbon\Carbon::parse($registration->shift->start)->locale('id')->translatedFormat('l, d F Y') . ' '.  substr(substr($registration->shift->start, -8), 0, 5) .  '-' . substr(substr($registration->shift->end, -8), 0, 5),
                    'no_hp' => $registration->no_hp,
                    'vehicle_type' => $registration->vehicle_type,
                    'manufacture' => $registration->manufacture->name,
                    'license_plate' => $registration->license_plate,
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
            $registration = Registration::with('shift', 'job', 'services', 'user')->where('id', $id)->get();

            $registration = $registration->map(function($registration){

                return [
                    'registration_number' => $registration->registration_number,
                    'email' =>  $registration->user->email,
                    'fullname' => $registration->fullname,
                    'services' => $registration->services,
                    'shift' => \Carbon\Carbon::parse($registration->shift->start)->locale('id')->translatedFormat('l, d F Y') . ' '.  substr(substr($registration->shift->start, -8), 0, 5) .  '-' . substr(substr($registration->shift->end, -8), 0, 5),
                    'no_hp' => $registration->no_hp,
                    'vehicle_type' => $registration->vehicle_type,
                    'manufacture' => $registration->manufacture->name,
                    'license_plate' => $registration->license_plate,
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

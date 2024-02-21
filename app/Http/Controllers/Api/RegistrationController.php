<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Casts\ArrayObject;

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
                    'id' => $registration->id,
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
                    'id' => $registration->id,
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

    public function exportToFirebase()
    {
        try {
            $registrations = Registration::with(['shift', 'job', 'services' => function($query) {
                $query->select('name');
            }, 'user', 'manufacture'])->get();

            $registrations = $registrations->mapWithKeys(function($registration, $key){

                return [
                    str_pad($key + 1, 3, '0', STR_PAD_LEFT) => [
                        "email" => $registration->user->email,
                        "kendaraan" => $registration->vehicle_type,
                        "merk" => $registration->manufacture->name,
                        "nama" => $registration->fullname,
                        "no_reg" => $registration->registration_number,
                        "no_urut" => str_pad($key + 1, 3, '0', STR_PAD_LEFT),
                        "nopol" => $registration->license_plate,
                        "pekerjaan" => $registration->job->name,
                        "search" => "",
                        "shift" => $registration->shift->start . ' sampai ' . $registration->shift->end,
                        "status" => $registration->is_scan ? 'Selesai' : 'Belum Selesai',
                        "telp" => $registration->no_hp,
                        "tgl_scan" => $registration->scan_date ?? '',
                        "tgl_service" => "",
                        "token" => $registration->token,
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'register' => $registrations,
                'service' => $registrations,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }
}

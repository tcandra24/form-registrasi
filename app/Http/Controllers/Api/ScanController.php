<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Registration;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function scan($token)
    {
        try {
            $registration = Registration::select('is_scan')->where('token', $token);
            if (!$registration->exists()) {
                throw new \Exception('Token tidak ditemukan');
            }

            if ($registration->first()->is_scan) {
                throw new \Exception('User Sudah Scan QrCode');
            }

            $registration->update([
                'is_scan' => true,
                'scan_date' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Scan berhasil'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    public function manualCheckIn($noRegistration)
    {
        try {
            $registration = Registration::select('is_scan')->where('registration_number', $noRegistration);
            if (!$registration->exists()) {
                throw new \Exception('Nomet Registrasi tidak ditemukan');
            }

            if ($registration->first()->is_scan) {
                throw new \Exception('User Sudah Scan QrCode');
            }

            $registration->update([
                'is_scan' => true,
                'scan_date' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check In berhasil'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }
}

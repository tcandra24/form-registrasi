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
            $registration = Registration::where('token', $token)->where('is_scan', false);
            if (!$registration->exists()) {
                throw new \Exception('User tidak ditemukan');
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
        dd($token);
    }
}

<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\RegistrationMechanic;

class RegistrationMechanicController extends Controller
{
    public function download()
    {
        $registration = RegistrationMechanic::where('user_id', Auth::user()->id)->first();
        $fileName = 'qr-code-' . $registration->token . '.svg';

        return response()->download(Storage::path('public/qr-codes/') . $fileName, $fileName);
    }
}

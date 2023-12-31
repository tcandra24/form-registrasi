<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Registration AS RegistrationModel;

class QrCodeController extends Controller
{
    public function download()
    {
        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();
        $fileName = 'qr-code-' . $registration->token . '.svg';

        return response()->download(Storage::path('public/qr-codes/') . $fileName, $fileName);
    }
}

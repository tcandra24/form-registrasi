<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\Registration AS RegistrationModel;

class QrCodeController extends Controller
{
    public function download()
    {
        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();
        return response()->streamDownload(
            function () use ($registration){
                echo QrCode::size(200)->style('round')->eye('circle')->generate($registration->token);
            },
            'qr-code.png',
            [
                'Content-Type' => 'image/png'
            ]
        );
    }
}

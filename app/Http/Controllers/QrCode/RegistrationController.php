<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Registration AS RegistrationModel;

class RegistrationController extends Controller
{
    public function download()
    {
        $registration = RegistrationModel::where('user_id', Auth::user()->id)->first();
        $fileName = 'qr-code-' . $registration->token . '.svg';

        return response()->download(Storage::path('public/qr-codes/') . $fileName, $fileName);
    }

    public function show($token)
    {
        if(!RegistrationModel::where('token', $token)->exists()){
            abort(404);
        }

        $registration = RegistrationModel::where('token', $token)->first();

        return view('qr-code.show', [
            'registration' => $registration,
        ]);
    }
}

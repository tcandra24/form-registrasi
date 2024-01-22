<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\RegistrationMechanic;
use App\Models\User;

class RegistrationMechanicImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row['nama_lengkap']){
                $user = User::select('id', 'name')->where('email', $row['email'])->first();
                $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $user->name), $user->id . $user->name);

                RegistrationMechanic::create([
                    'fullname' => $row['nama_lengkap'],
                    'registration_number' => $row['nomer_registrasi'],
                    'no_hp' =>  $row['no_handphone'],
                    'workshop_name' => $row['nama bengkel'],
                    'address' => $row['alamat'],
                    'user_id' => $user->id,
                    'token' => $token
                ]);
            }
        }
    }
}

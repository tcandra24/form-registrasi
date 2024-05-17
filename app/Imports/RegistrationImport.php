<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Registration;
use App\Models\Service;
use App\Models\Job;
use App\Models\Shift;
use App\Models\User;
use App\Models\Manufacture;

class RegistrationImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row['nama_lengkap']){
                $user = User::select('id', 'name')->where('email', $row['email'])->first();
                $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $user->name), $user->id . $user->name);
                $job = Job::select('id')->where('name', strtolower($row['pekerjaan']))->first();
                $shift = Shift::select('id')->where('name', strtolower($row['nama_shift']))->first();
                $manufacture = Manufacture::select('id')->where('name', strtolower($row['pabrikan_motor']))->first();

                $service = explode("\n", $row['jasa']);
                $services = Service::select('id')->whereIn('name', $service)->get();

                $registration = Registration::create([
                    'fullname' => $row['nama_lengkap'],
                    'registration_number' => $row['nomer_registrasi'],
                    'no_hp' =>  $row['no_handphone'],
                    'vehicle_type' => $row['jenis_kendaraan'],
                    'license_plate' => $row['plat_nomor'],
                    'job_id' => $job->id,
                    'shift_id' => $shift->id,
                    'user_id' => $user->id,
                    'manufacture_id' => $manufacture->id,
                    'token' => $token
                ]);

                $services = Service::select('id')->whereIn('id', $services)->get();

                $registration->services()->attach($services);
            }
        }
    }
}

<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;
// use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Registration;
use App\Models\Event;
use App\Models\User;

class RegistrationImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row['nama_lengkap']){
                $event = Event::where('name', '<>', '')->first();
                $email = explode(' ', strtolower($row['nama_lengkap']));
                $user = User::create([
                    'email'     => $email[0] . (count($email) > 1 ? $email[1] : '') . '@gmail.com',
                    'no_hp'     => $row['no_handphone'] ?? '-',
                    'name'      => $row['nama_lengkap'],
                    'password'  => Hash::make(123456789),
                    'event_id'  => $event->id,
                ]);

                $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $row['nama_lengkap']), rand(1, 10) . $row['nama_lengkap']);
                QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
                $registration_max = Registration::withTrashed()->where('event_slug', $event->slug)->max('registration_number') + 1;
                $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['tgl_lahir']))->format('Y-m-d');
                Registration::create([
                    'fullname' => $row['nama_lengkap'],
                    'date_birth' => $date,
                    'address' => $row['alamat'] ?? '-',
                    'gender' => $row['gender'] ?? '-',
                    'bood_type' => $row['golongan_darah'] ?? '-',
                    'registration_number' => $registration_number,
                    'no_hp' => $row['no_handphone'] ?? '-',
                    'vehicle_type' => $row['jenis_kendaraan'] ?? '-',
                    'license_plate' => $row['plat_nomor'] ?? '-',
                    'event_slug' => $event->slug,
                    'user_id' => $user->id,
                    'token' => $token
                ]);
            }
        }
    }
}

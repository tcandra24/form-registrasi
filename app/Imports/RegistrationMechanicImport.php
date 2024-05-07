<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\RegistrationMechanic;
use App\Models\Event;
use App\Models\User;
use App\Models\Job;

class RegistrationMechanicImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if($row['nama_lengkap']){
                // $user = User::select('id', 'name')->where('email', $row['email'])->first();
                // $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $user->name), $user->id . $user->name);

                // RegistrationMechanic::create([
                //     'fullname' => $row['nama_lengkap'],
                //     'registration_number' => $row['nomer_registrasi'],
                //     'no_hp' =>  $row['no_hp'],
                //     'workshop_name' => $row['nama bengkel'],
                //     'address' => $row['alamat'],
                //     'user_id' => $user->id,
                //     'token' => $token
                // ]);

                // --------------------------------------------
                // if(User::where('no_hp', $row['no_hp'])->exists()){
                //     continue;
                // }

                $event = Event::where('name', '<>', '')->first();
                $email = explode(' ', strtolower($row['nama_lengkap']));
                $nama_bengkel = str_replace(' ', '', strtolower($row['nama_bengkel']));
                $user = User::create([
                    'email'     => $email[0] . (count($email) > 1 ? $email[1] : '') . '.' . $nama_bengkel . '@gmail.com',
                    'no_hp'     => $row['no_hp'] ?? '-',
                    'name'      => $row['nama_lengkap'],
                    'password'  => Hash::make(123456789),
                    'event_id'  => $event->id,
                ]);

                $permissions = Permission::all();
                $role = Role::where('name', 'user')->first();
                $role->syncPermissions($permissions);
                $user->assignRole($role);

                $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $row['nama_lengkap']), rand(1, 10) . $row['nama_lengkap']);
                QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
                $registration_max = RegistrationMechanic::withTrashed()->where('event_slug', $event->slug)->max('registration_number') + 1;
                $registration_number = str_pad($registration_max, 5, '0', STR_PAD_LEFT);

                // $job = Job::select('id')->where('name', strtolower($row['pekerjaan']))->first();

                // $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['tgl_lahir']))->format('Y-m-d');
                RegistrationMechanic::create([
                    // 'fullname' => $row['nama_lengkap'],
                    // 'date_birth' => $date,
                    // 'address' => $row['alamat'] ?? '-',
                    // 'gender' => $row['gender'] ?? '-',
                    // 'bood_type' => $row['golongan_darah'] ?? '-',
                    // 'registration_number' => $registration_number,
                    // 'no_hp' => $row['no_hp'] ?? '-',
                    // 'vehicle_type' => $row['jenis_kendaraan'] ?? '-',
                    // 'license_plate' => $row['plat_nomor'] ?? '-',
                    // 'event_slug' => $event->slug,
                    // 'user_id' => $user->id,
                    // 'job_id' => $job->id,
                    // 'token' => $token,

                    'fullname' => $row['nama_lengkap'],
                    'registration_number' => $registration_number,
                    'no_hp' => $row['no_hp'] ?? '-',
                    'workshop_name' => $row['nama_bengkel'],
                    'address' => $row['alamat'] ?? '-',
                    'user_id' => $user->id,
                    'event_slug' => $event->slug,
                    'is_vip' => false,
                    'token' => $token
                ]);
            }
        }
    }
}

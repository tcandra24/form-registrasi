<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Fuboru Registrasi
    </div>
</div>
<table style="width: 100%">
    <thead>
        <tr style="background-color: #e6e6e7;">
            <th scope="col">No</th>
            <th scope="col">Nomer Registrasi</th>
            <th scope="col">Email</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Jasa</th>
            <th scope="col">Shift</th>
            <th scope="col">No Handphone</th>
            <th scope="col">Jenis Kendaraan</th>
            <th scope="col">Pabrikan Motor</th>
            <th scope="col">Plat Nomor</th>
            <th scope="col">Status Scan</th>
            <th scope="col">Tanggal Scan</th>
            <th scope="col">Pekerjaan</th>
            <th scope="col">Token</th>
        </tr>
    </thead>
    <tbody>
        @foreach($registrations as $registration)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $registration->registration_number }}</td>
            <td>{{ $registration->user->email }}</td>
            <td>{{ $registration->fullname }}</td>
            <td>
                @foreach($registration->services AS $service)
                    <p>{{ $service->name }}</p>
                @endforeach
            </td>
            <td>
                <p>{{ \Carbon\Carbon::parse($registration->shift->start)->locale('id')->translatedFormat('l, d F Y') }}</p>
                <p>{{ substr(substr($registration->shift->start, -8), 0, 5) }} - {{ substr(substr($registration->shift->end, -8), 0, 5) }}</p>
            </td>
            <td>{{ $registration->no_hp }}</td>
            <td>{{ $registration->vehicle_type }}</td>
            <td>{{ $registration->manufacture->name }}</td>
            <td>{{ $registration->license_plate }}</td>
            <td>
                @if($registration->is_scan)
                    Sudah Scan
                @else
                    Belum Scan
                @endif
            </td>
            <td>{{ $registration->scan_date ?? '-' }}</td>
            <td>{{ $registration->job->name }}</td>
            <td>{{ $registration->token }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

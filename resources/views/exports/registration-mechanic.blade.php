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
            <th scope="col">Nama Bengkel</th>
            <th scope="col">Alamat</th>
            <th scope="col">No Handphone</th>
            <th scope="col">Status Scan</th>
            <th scope="col">Tanggal Scan</th>
            <th scope="col">Token</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registrations as $registration)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $registration->registration_number }}</td>
                <td>{{ $registration->user->email }}</td>
                <td>{{ $registration->fullname }}</td>
                <td>{{ $registration->workshop_name }}</td>
                <td>{{ $registration->address }}</td>
                <td>{{ $registration->no_hp }}</td>
                <td>
                    @if ($registration->is_scan)
                        Sudah Scan
                    @else
                        Belum Scan
                    @endif
                </td>
                <td>{{ $registration->scan_date ?? '-' }}</td>
                <td>{{ $registration->token }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

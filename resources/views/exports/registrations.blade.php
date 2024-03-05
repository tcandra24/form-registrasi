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
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Alamat</th>
            <th scope="col">Golongan Darah</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">No Handphone</th>
            <th scope="col">Jenis Kendaraan</th>
            <th scope="col">Plat Nomor</th>
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
                <td>{{ $registration->gender }}</td>
                <td>{{ $registration->address }}</td>
                <td>{{ $registration->bood_type }}</td>
                <td>{{ $registration->date_birth }}</td>
                <td>{{ $registration->no_hp }}</td>
                <td>{{ $registration->vehicle_type }}</td>
                <td>{{ $registration->license_plate }}</td>
                <td>{{ $registration->token }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

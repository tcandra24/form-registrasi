@extends('layouts/dashboard')

@section('title')
Syarat & Ketentuan
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Syarat & Ketentuan</h5>
        <ol>
            <li>Pendaftaran per akun <b>HANYA</b> 1 orang/driver saja.</li>
            <li><b>WAJIB</b> mencantumkan jenis service yang akan dipilih.</li>
            <li>Setiap driver yang sudah registrasi & melakukan validasi, ber-hak mendapatkan Free Busi Bosch dan Merchandise.</li>
            <li><b>WAJIB HADIR</b> mengikuti jadwal shift yang telah dipilih (Sesuai kuota nya).</li>
            <li>Bagi yang sudah melakukan registrasi, harap menyimpan nomer registrasi dan barcode untuk ditunjukkan kepada admin validasi saat di lokasi acara.</li>
            <li>Jika yang bersangkutan berhalangan hadir, boleh diwakilkan dengan menunjukkan nomer registrasi dan barcode yang telah terdaftar.</li>
        </ol>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection

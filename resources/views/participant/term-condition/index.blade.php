@extends('layouts/dashboard')

@section('title')
    Syarat & Ketentuan
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Syarat & Ketentuan</h5>
            <ol>
                <li>Berlaku untuk semua driver Ojek Online yang berada di Bandung.</li>
                <li>Menunjukkan bukti nomer registrasi dan scan barcode saat di lokasi acara.</li>
                <li>Bagi yang telah mendaftar berhak mendapatkan Busi Bosch gratis dan pembelian spare part product dengan
                    harga discount.</li>
                <li>Bagi yang telah mendaftar berhak mendapatkan free jasa penggantian Oli, Aki, dan pembersihan filter
                    udara.</li>
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

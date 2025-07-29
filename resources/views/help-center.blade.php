@extends('layouts.support')

@section('content')
    <div class="container my-5">
        <div class="text-center mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="AWOB Logo" style="height: 50px;">
            <h1 class="mt-3 fw-bold">Pusat Bantuan</h1>
            <a class="text-muted text-decoration-none">Temukan jawaban atas pertanyaan umum seputar layanan AWAB</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 d-flex flex-column gap-4">
                {{-- Card 1 --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Apa itu AWAB?</h5>
                        <p class="card-text">
                            <strong>AWAB (Al-Amin Waste Bank)</strong> adalah platform digital berbasis web dan mobile untuk mendukung
                            pengelolaan sampah secara terorganisir, dikelola oleh Generasi Informatika Kreatif.
                        </p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Bagaimana cara mendaftar akun?</h5>
                        <p class="card-text">
                            Kunjungi halaman <a class="text-success text-decoration-none" href="{{ url('/register') }}">pendaftaran</a>, lalu isi data diri Anda
                            secara lengkap. Setelah berhasil, Anda bisa langsung menggunakan fitur AWAB.
                        </p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Lupa password?</h5>
                        <p class="card-text">
                            Klik “Lupa Password” di halaman login. Kami akan mengirimkan tautan untuk mereset kata sandi
                            Anda melalui email yang terdaftar.
                        </p>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Bagaimana saya dapat menghubungi tim AWAB?</h5>
                        <p class="card-text">
                            Anda dapat menghubungi kami melalui email resmi, media sosial, atau menu "Hubungi Kami" di
                            aplikasi. Kami akan berusaha merespons dalam waktu 1x24 jam.
                        </p>
                    </div>
                </div>

                {{-- Card 5 --}}
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Apakah data saya aman?</h5>
                        <p class="card-text">
                            Keamanan data Anda adalah prioritas kami. Silakan lihat <a class="text-success text-decoration-none" href="{{ url('/policy') }}">Kebijakan
                                Privasi</a> kami untuk informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

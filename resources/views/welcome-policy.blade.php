@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    <div class="container my-5">
        <div class="text-center mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="AWOB Logo" style="height: 50px;">
            <h1 class="mt-3 fw-bold">Kebijakan & Privasi</h1>
            <a class="text-muted text-decoration-none">Perlindungan Data dan Informasi Pengguna AWAB (Al-Amin Waste Bank)</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- PENDAHULUAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <p>
                            <strong>Kebijakan Privasi Sistem Online Manajemen Sampah (AWAB)</strong> mengatur perlindungan
                            atas informasi yang Anda berikan saat menggunakan layanan kami di
                            <a class="text-success text-decoration-none" href="https://www.awab.id" target="_blank">www.awab.id</a>.
                            Kebijakan ini mencakup data pribadi yang dikumpulkan, penggunaan data tersebut, serta hak dan
                            kewajiban pengguna dalam menjaga keamanan data.
                        </p>
                    </div>
                </div>

                <!-- DATA PENGGUNA -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        A. Data Pengguna
                    </div>
                    <div class="card-body">
                        <p>
                            AWAB mengumpulkan informasi seperti nama, email, dan data lain yang diperlukan untuk menunjang
                            layanan.
                            Data disimpan secara elektronik dan dilindungi oleh sistem keamanan kami.
                            Namun, AWAB tidak dapat menjamin sepenuhnya keamanan dari upaya akses ilegal oleh pihak ketiga.
                        </p>
                    </div>
                </div>

                <!-- AKUN DAN KEAMANAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        B. Akun dan Keamanan
                    </div>
                    <div class="card-body">
                        <p>
                            Pengguna bertanggung jawab penuh atas kerahasiaan kata sandi dan token akses API.
                            AWAB menyediakan fitur seperti pemulihan kata sandi untuk membantu keamanan akun.
                            Kami tidak bertanggung jawab atas penyalahgunaan akun akibat kelalaian pengguna.
                        </p>
                    </div>
                </div>

                <!-- KRITIK DAN SARAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        C. Kritik dan Saran
                    </div>
                    <div class="card-body">
                        <p>
                            Kami terbuka terhadap kritik dan saran yang dapat disampaikan melalui media sosial resmi AWAB
                            untuk meningkatkan kualitas layanan.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

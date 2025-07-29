@extends('layouts.app')

@section('content')
    @include('partials.navbar')
    <div class="container my-5">
        <div class="text-center mb-5">
            <img src="{{ asset('images/logo.png') }}" alt="AWOB Logo" style="height: 50px;">
            <h1 class="mt-3 fw-bold">Syarat & Ketentuan</h1>
            <a class="text-muted text-decoration-none ">Ketentuan Penggunaan Layanan AWAB (Al-Amin Waste Bank)</a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- PENDAHULUAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <p>
                            AWAB (Al-Amin Waste Bank) adalah platform berbasis web dan mobile yang dikelola oleh Generasi
                            Informatika Kreatif.
                            Platform ini bertujuan untuk mendukung pengelolaan sampah secara digital, efisien, dan
                            terorganisir.
                            Dengan menggunakan layanan kami, pengguna dianggap telah membaca, memahami, dan menyetujui
                            seluruh Syarat & Ketentuan yang berlaku.
                        </p>
                    </div>
                </div>

                <!-- DEFINISI -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        A. Definisi
                    </div>
                    <div class="card-body">
                        <p>
                            AWAB (Al-Amin Waste Bank) merujuk pada sistem digital berbasis web dan mobile yang dirancang
                            untuk mengelola kegiatan bank sampah,
                            mulai dari pencatatan transaksi, edukasi lingkungan, hingga pelaporan data. Sistem ini merupakan
                            produk dari Generasi Informatika Kreatif.
                        </p>
                    </div>
                </div>

                <!-- AKUN & KEAMANAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        B. Akun & Keamanan
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Pengguna wajib memiliki kapasitas hukum untuk menggunakan layanan
                                ini.</li>
                            <li class="list-group-item">Pendaftaran akun tidak dikenakan biaya apa pun.</li>
                            <li class="list-group-item">AWAB berhak mengambil tindakan atas pelanggaran tanpa pemberitahuan
                                sebelumnya.</li>
                            <li class="list-group-item">Pengguna bertanggung jawab menjaga kerahasiaan akun dan segera
                                melapor jika terjadi penyalahgunaan.</li>
                            <li class="list-group-item">AWAB tidak bertanggung jawab atas kerugian yang timbul akibat
                                kelalaian pengguna.</li>
                        </ul>
                    </div>
                </div>

                <!-- BATAS TANGGUNG JAWAB -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        C. Batas Tanggung Jawab
                    </div>
                    <div class="card-body">
                        <p>
                            Layanan AWAB disediakan sebagaimana adanya ("as is"). Kami tidak menjamin bahwa sistem akan
                            selalu berjalan tanpa gangguan,
                            kesalahan, atau kerusakan yang mungkin terjadi karena faktor teknis, pihak ketiga, atau keadaan
                            di luar kendali kami.
                        </p>
                    </div>
                </div>

                <!-- PERUBAHAN KETENTUAN -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-header bg-light fw-semibold">
                        D. Perubahan Ketentuan
                    </div>
                    <div class="card-body">
                        <p>
                            AWAB berhak mengubah atau memperbarui Syarat & Ketentuan ini kapan saja tanpa pemberitahuan
                            sebelumnya.
                            Setiap perubahan akan langsung berlaku dan penggunaan layanan setelah perubahan tersebut
                            dianggap sebagai bentuk persetujuan Anda.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

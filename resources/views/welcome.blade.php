@extends('layouts.app')

@section('content')
    <style>
        @keyframes scroll-left {
            from {
                transform: translateX(0%);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @keyframes scroll-right {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0%);
            }
        }

        body {
            min-height: 200vh;
        }

        #stickyNavbar {
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }

        #stickyNavbar.showing {
            display: block !important;
            opacity: 1;
            pointer-events: auto;
        }

        /* Pattern background */
        .pattern-square {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("/images/topography.svg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: top center;
            z-index: 0;
        }

        /* Marquee */
        .marquee .track,
        .marquee .track-2 {
            display: flex;
            gap: 1rem;
        }

        .marquee {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .track {
            display: flex;
            animation: scroll-left 30s linear infinite;
        }

        .track.reverse {
            animation-direction: reverse;
        }

        .logo-container {
            display: inline-block;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 430px) {
            .navbar-collapse {
                justify-content: center !important;
            }
        }
    </style>

    @include('partials.navbar')

    <!-- Wrapper dengan posisi relatif untuk overlay -->
    <div class="position-relative overflow-hidden bg-white">
        <!-- Pattern background transparan -->
        <div class="pattern-square"></div>

        <!-- Konten -->
        <section class="container py-lg-8 py-5 position-relative z-10" data-aos="fade-in">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-12" data-aos="zoom-in" data-group="page-title" data-delay="700">
                    <div class="text-center d-flex flex-column gap-5">
                        <div class="d-flex justify-content-center">
                            <span
                                class="bg-light bg-opacity-50 text-success border-success border p-3 m-2 fs-6 rounded-pill lh-1 d-flex align-items-center">
                                <span class="px-2">Selamat Datang, Sahabat Alam!</span>
                            </span>
                        </div>
                        <div class="d-flex flex-column gap-3 mx-lg-8">
                            <h1 class="mb-0 display-1 text-success fw-bold">Bersama Jaga Bumi!</h1>
                            <p class="mb-0 lead">Platform edukatif dan aksi nyata untuk pengelolaan sampah dan pelestarian
                                lingkungan.</p>
                        </div>
                        <div class="d-flex flex-row gap-2 justify-content-center">
                            <a href="#aksi" class="btn btn-success">Gabung Aksi</a>
                            <a href="#program" class="btn btn-outline-success">Lihat Program</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Preview Image Start -->
    <div class="my-xl-7 py-5">
        <div class="container-fluid" data-cue="fadeIn">
            <div class="row mb-7 pb-2 text-center justify-content-center gy-4">
                <div class="col-lg-12 col-12">
                    <div class="marquee h-auto" data-aos="slide-left">
                        <div class="track">
                            @for ($i = 1; $i <= 5; $i++)
                                <div>
                                    <img src="{{ asset('images/banner' . $i . '.jpg') }}" alt="Banner {{ $i }}"
                                        class="rounded-3 border" width="360" />
                                </div>
                            @endfor
                            @for ($i = 1; $i <= 5; $i++)
                                <div>
                                    <img src="{{ asset('images/banner' . $i . '.jpg') }}" alt="Banner {{ $i }}"
                                        class="rounded-3 border" width="360" />
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-12">
                    <div class="marquee h-auto" data-aos="slide-right">
                        <div class="track reverse">
                            @for ($i = 1; $i <= 5; $i++)
                                <div>
                                    <img src="{{ asset('images/banner' . $i . '.jpg') }}" alt="Banner {{ $i }}"
                                        class="rounded-3 border" width="360" />
                                </div>
                            @endfor
                            @for ($i = 1; $i <= 5; $i++)
                                <div>
                                    <img src="{{ asset('images/banner' . $i . '.jpg') }}" alt="Banner {{ $i }}"
                                        class="rounded-3 border" width="360" />
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preview Image End -->

    <!-- Banner Slider -->
    {{-- <div class="swiper w-full h-[300px] md:h-[400px] lg:h-[500px]">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('images/banner1.jpg') }}" class="w-full h-full object-cover" alt="Slide 1">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner2.jpg') }}" class="w-full h-full object-cover" alt="Slide 2">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('images/banner3.jpg') }}" class="w-full h-full object-cover" alt="Slide 3">
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div> --}}


    <!-- Hero -->
    <section class="py-5 position-relative text-center"
        style="background: url('/images/topography.svg') center/cover no-repeat; background-opacity: 0.1;">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center">
            <img src="{{ asset('images/hero-logo.png') }}" alt="Hero Logo" class="mb-3 mb-md-0 me-md-4"
                style="width: 500px;" data-aos="zoom-in" />
            <div class="text-start">
                <p class="mb-2 fs-4 fw-semibold text-success-emphasis" data-aos="fade-left">🌱 Wujudkan Lingkungan Bersih
                </p>
                <p class="mb-2 fs-4 fw-semibold text-success-emphasis" data-aos="fade-left" data-aos-delay="100">♻️ Sampah
                    Bernilai</p>
                <p class="mb-0 fs-4 fw-semibold text-success-emphasis" data-aos="fade-left" data-aos-delay="200">🕌
                    Menerapkan Ajaran Rasulullah</p>
            </div>
        </div>
    </section>


    <!-- Kegiatan Kami -->
    <div class="container my-5" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-center mb-4 fs-1 fw-bold">Kegiatan Kami</h2>
        <div class="row g-4">
            @php
                $activities = [
                    [
                        'img' => 'pic1.png',
                        'title' => 'Pencatatan Setoran Sampah',
                        'desc' =>
                            'Memudahkan pencatatan transaksi setoran sampah ke dalam kategori yang terstruktur dan transparan.',
                    ],
                    [
                        'img' => 'pic2.png',
                        'title' => 'Klasifikasi & Labelisasi',
                        'desc' => 'Memberi label atau klasifikasi pada jenis sampah untuk pengelolaan dan pelaporan.',
                    ],
                    [
                        'img' => 'pic3.png',
                        'title' => 'Manajemen Lokasi & Penjemputan',
                        'desc' => 'Mengatur jadwal penjemputan sampah dari rumah nasabah atau lokasi pengumpulan.',
                    ],
                ];
            @endphp
            @foreach ($activities as $act)
                <div class="col-md-4" data-aos="zoom-in">
                    <div class="card border-0 h-100 text-center shadow">
                        <img src="{{ asset('images/' . $act['img']) }}" class="card-img-top p-3" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $act['title'] }}</h5>
                            <p class="card-text">{{ $act['desc'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Nilai Utama -->
    <section class="py-5 position-relative text-center"
        style="background: url('/images/topography.svg') center/cover no-repeat; background-opacity: 0.1;"
        data-aos="fade-in">
        <div class="container my-5" data-aos="fade-up">
            <h2 class="text-center mb-4 fs-1 fw-bold">Nilai Utama Kami</h2>
            <div class="row g-4">
                @php
                    $values = [
                        [
                            'img' => 'ter.png',
                            'title' => 'Terintegrasi',
                            'desc' =>
                                'Data Bank Sampah yang tergabung terintegrasi otomatis, memudahkan pemantauan & perencanaan.',
                        ],
                        [
                            'img' => 'trans.png',
                            'title' => 'Transparan',
                            'desc' => 'Setiap transaksi dicatat secara terbuka, transparan & akurat.',
                        ],
                        [
                            'img' => 'am.png',
                            'title' => 'Aman',
                            'desc' => 'Data diamankan dengan SSL/TLS & enkripsi dalam setiap transaksi.',
                        ],
                        [
                            'img' => 'prak.png',
                            'title' => 'Praktis',
                            'desc' => 'Pengelolaan digital yang efisien & mendukung paperless activity.',
                        ],
                    ];
                @endphp
                @foreach ($values as $val)
                    <div class="col-sm-6 col-md-3" data-aos="flip-left">
                        <div class="card bg-transparent border-0 h-100 text-center shadow-m">
                            <img src="{{ asset('images/' . $val['img']) }}" class="card-img-top p-3" alt="">
                            <div class="card-body">
                                <h3 class="card-title fw-bold">{{ $val['title'] }}</h3>
                                <p class="card-text">{{ $val['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Call to Action: Dukung Program -->
    <section class="py-5 mb-3 text-dark" data-aos="fade-in">
        <div class="container my-lg-7" data-aos="zoom-in">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-md-10 col-12 d-flex flex-column gap-4">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none"
                            viewBox="0 0 24 24" stroke="#15803D" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="fs-1 fw-bold">Ayo Wujudkan Lingkungan Bersih & Berkah!</h2>
                        <p class="mb-0 fs-5 text-muted">
                            Mari dukung gerakan amal ini, Bergabung bersama kami dalam menciptakan
                            lingkungan sehat, bersih, dan bernilai ekonomi untuk masyarakat.
                        </p>
                    </div>
                    <div>
                        <form class="row g-2 d-flex mx-lg-7" action="#" method="post" name="support-program-form"
                            novalidate>
                            <div class="col-md-9 col-12">
                                <input type="email" id="supportEmail" class="form-control" name="EMAIL"
                                    placeholder="Masukkan email Anda untuk bergabung" required />
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="d-grid">
                                    <button class="btn btn-success" type="submit">Dukung Sekarang</button>
                                </div>
                            </div>
                            <div style="position: absolute; left: -5000px" aria-hidden="true">
                                <input class="antispam" type="text" name="b_fake_field" tabindex="-1" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!---Footer Content-->
    <footer class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <!-- Kolom Konten 1-3 -->
                <div class="col-lg-9 col-12">
                    <div class="row" id="ft-links">
                        <!-- Kolom 1 -->
                        <div class="col-lg-3 col-12 mb-4">
                            <div>
                                <div class="mb-3 pb-2 d-flex justify-content-between border-bottom border-bottom-lg-0">
                                    <h4 class="text-white">Kegiatan</h4>
                                    <a class="d-block d-lg-none text-white" data-bs-toggle="collapse"
                                        href="#collapseLandingService" role="button" aria-expanded="false"
                                        aria-controls="collapseLanding">
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </div>
                                <div class="collapse d-lg-block" id="collapseLandingService" data-bs-parent="#ft-links">
                                    <ul class="list-unstyled mb-0 py-3 py-lg-0">
                                        <li class="mb-2"><a href="#"
                                                class="text-decoration-none text-white">Pencatatan Setoran Sampah</a></li>
                                        <li class="mb-2"><a href="#"
                                                class="text-decoration-none text-white">Klasifikasi & Labelisasi</a></li>
                                        <li class="mb-2"><a href="#"
                                                class="text-decoration-none text-white">Manajemen Lokasi</a></li>
                                        <li class="mb-2"><a href="#"
                                                class="text-decoration-none text-white">Penjemputan Sampah</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="col-lg-3 col-12 mb-4">
                            <div class="mb-3 pb-2 d-flex justify-content-between border-bottom border-bottom-lg-0">
                                <h4 class="text-white">Nilai Utama</h4>
                                <a class="d-block d-lg-none text-white" data-bs-toggle="collapse"
                                    href="#collapseLandingPerusahaan" role="button" aria-expanded="false"
                                    aria-controls="collapseLanding">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                            <div class="collapse d-lg-block" id="collapseLandingPerusahaan" data-bs-parent="#ft-links">
                                <ul class="list-unstyled mb-0 py-3 py-lg-0">
                                    <li class="mb-2"><a href="#"
                                            class="text-white text-decoration-none">Terintegrasi</a></li>
                                    <li class="mb-2"><a href="#"
                                            class="text-white text-decoration-none">Transparan</a></li>
                                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Aman</a>
                                    </li>
                                    <li class="mb-2"><a href="#"
                                            class="text-white text-decoration-none">Praktis</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Kolom 3 -->
                        <div class="col-lg-3 col-12 mb-4">
                            <div class="mb-3 pb-2 d-flex justify-content-between border-bottom border-bottom-lg-0">
                                <h4 class="text-white">Support</h4>
                                <a class="d-block d-lg-none text-white" data-bs-toggle="collapse"
                                    href="#collapseLandingLegal" role="button" aria-expanded="false"
                                    aria-controls="collapseLanding">
                                    <i class="bi bi-chevron-down"></i>
                                </a>
                            </div>
                            <div class="collapse d-lg-block" id="collapseLandingLegal" data-bs-parent="#ft-links">
                                <ul class="list-unstyled mb-0 py-3 py-lg-0">
                                    <li class="mb-2">
                                        <a href="{{ url('/home/terms') }}" class="text-white text-decoration-none">
                                            Syarat & Ketentuan
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ url('/home/policy') }}" class="text-white text-decoration-none">
                                            Kebijakan Privasi
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ url('/home/help-center') }}" class="text-white text-decoration-none">
                                            FAQ
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 4: MAP -->
                <div class="col-lg-3 col-12 mb-4">
                    <div class="mb-3 pb-2 d-flex justify-content-between border-bottom border-bottom-lg-0">
                        <h4 class="text-white">Lokasi Kami</h4>
                    </div>
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d12689.52299331761!2d111.6219883!3d-7.1563986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sid!4v1689362789572!5m2!1sen!2sid"
                            width="100%" height="250" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                    </div>
                </div>
            </div>

            <hr class="border-bold border-bottom-lg-0 mt-3" />

            <!-- Copyright -->
            <div class="container mt-7 pt-lg-7">
                <div class="row align-items-center">
                    <!-- Kiri: Logo -->
                    <div class="col-md-3">
                        <div class="logo-container">
                            <a href="/">
                                <img src="{{ asset('images/logo-icon.png') }}" alt="Logo AWOB"
                                    style="height: 48px; width: auto;">
                            </a>
                        </div>
                    </div>



                    <!-- Tengah: Copyright -->
                    <div class="col-md-9 col-lg-6">
                        <div class="small mb-3 mb-lg-0 text-lg-center">
                            Copyright © 2025

                            <span class="text-primary"><a>AWOB</a></span>
                            | Designed by
                            <span class="text-primary"><a>AnzArt Studio</a></span>
                        </div>
                    </div>
                    <!-- Kanan: Sosial Media -->
                    <div class="col-md-3">
                        <div class="d-flex justify-content-center justify-content-md-end align-items-center">
                            <div class="d-flex gap-2">
                                <a href="#"
                                    class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px;">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="#"
                                    class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px;">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="#"
                                    class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px;">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="#"
                                    class="btn btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px;">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button -->
    <a href="#" id="scrollBtn" class="btn btn-success  position-fixed rounded shadow"
        style="bottom: 20px; right: 20px; z-index: 999; display: none;">
        <i class="bi bi-arrow-up"></i>
    </a>
@endsection
@push('scripts')
    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({
                duration: 800,
                easing: "ease-in-out",
                once: true,
            });

            const swiper = new Swiper(".swiper", {
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            const mainNavbar = document.querySelector('nav.navbar:not(#stickyNavbar)');
            const stickyNavbar = document.getElementById('stickyNavbar');

            window.addEventListener('scroll', function() {
                const triggerHeight = mainNavbar.offsetHeight;

                if (window.scrollY > triggerHeight) {
                    stickyNavbar.classList.add('showing');
                } else {
                    stickyNavbar.classList.remove('showing');
                }
            });

            window.addEventListener('scroll', function() {
                scrollBtn.style.display = window.scrollY > 100 ? 'block' : 'none';
            });

            scrollBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endpush

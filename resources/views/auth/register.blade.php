@extends('layouts.app')

@section('content')
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .bg-cover {
            background-image: url('{{ asset('images/topography.svg') }}');
            /* Ganti dengan path gambar background-mu */
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .login-box {
            max-width: 960px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #047857;
        }

        .btn-custom {
            background-color: #047857;
            color: white;
        }

        .btn-custom:hover {
            background-color: #065f46;
            color: white;
        }

        .text-small {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
        }
    </style>

    <div class="d-flex justify-content-center align-items-center bg-cover">
        <div class="container py-5">
            <div class="row login-box mx-auto">
                <!-- Kiri -->
                <div
                    class="col-md-6 login-left d-flex flex-column justify-content-center align-items-center text-center p-4 bg-light">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-3" style="height: 64px;">
                    <p class="text-center text-muted fs-5 fw-light">
                        Bergabunglah dengan kami<br>menuju lingkungan yang lebih baik
                    </p>
                </div>

                <!-- Kanan -->
                <div class="col-md-6 p-4">
                    <h1 class="h4 fw-bold text-dark mb-2">Daftar Akun AWAB</h1>
                    <p class="text-muted mb-4 text-small">Lengkapi informasi di bawah ini</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                value="{{ old('username') }}" placeholder="Masukkan Username..." required>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan E-Mail..."
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor HP</label>
                            <input type="tel" name="phone_number" class="form-control" id="phone_number" placeholder="Masukkan No. Handphone..."
                                value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password..." required
                                minlength="6">
                            <div class="form-text">Minimal 6 karakter</div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Masukkan Ulang Password..."
                                id="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-custom w-100">Daftar Akun</button>
                    </form>

                    <div class="text-small text-center mt-3">
                        <p class="mb-3">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                        <p>
                            <a href="{{ url('/') }}">Kembali ke Beranda</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

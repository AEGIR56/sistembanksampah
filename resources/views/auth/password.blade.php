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
                    <h5 class="text-muted">AWOB | Lupa Password</h5>
                </div>

                <!-- Kanan -->
                <div class="col-md-6 bg-white p-4">
                    <h4 class="fw-bold mb-3">Lupa Password</h4>
                    <p class="text-muted">Masukkan email / username / nomor HP Anda. Kami akan kirim tautan reset password.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="identifier" class="form-label">Email / Username / Nomor HP</label>
                            <input type="text" class="form-control @error('identifier') is-invalid @enderror"
                                name="identifier" id="identifier" value="{{ old('identifier') }}" required autofocus>
                            @error('identifier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">Kirim Permintaan Reset Password</button>
                    </form>

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('login') }}" class="text-small text-decoration-none">Kembali ke Login</a>
                        <a href="{{ url('/') }}" class="text-small text-decoration-none">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

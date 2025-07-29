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
                <!-- Left side -->
                <div
                    class="col-md-6 login-left d-flex flex-column justify-content-center align-items-center text-center p-4 bg-light">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-3" style="height: 64px;">
                    <p class="text-muted fs-5">Selangkah lebih dekat menuju<br> lingkungan yang lebih baik</p>
                </div>

                <!-- Right side -->
                <div class="col-md-6 p-4">
                    <h1 class="h4 fw-bold text-dark mb-2">Masuk ke AWAB</h1>
                    <p class="text-muted mb-4 text-small">Masuk ke akun Anda</p>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username / Email / No. HP</label>
                            <input type="text" name="username" id="username" class="form-control" required
                                value="{{ old('username') }}" placeholder="Masukkan Username/Email/No.Hp...">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required
                                placeholder="Masukkan Password...">
                        </div>

                        @if ($errors->has('loginError'))
                            <div class="text-danger text-small mb-3">{{ $errors->first('loginError') }}</div>
                        @endif

                        <button type="submit" class="btn btn-custom w-100" id="login-btn">
                            <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status"
                                aria-hidden="true"></span>
                            <span id="btn-text">Login</span>
                        </button>
                    </form>

                    <div class="text-small text-center mt-3">
                        <div class="d-flex justify-content-between mb-3">
                            <p class="mb-1 text-start">
                                Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
                            </p>
                            <p class="mb-1 text-end">
                                <a href="{{ route('password.request') }}">Lupa password?</a>
                            </p>
                        </div>
                        <p>
                            <a href="{{ url('/') }}">Kembali ke Beranda</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('login-btn').addEventListener('click', function() {
            document.getElementById('spinner').classList.remove('d-none');
            document.getElementById('btn-text').textContent = 'Logging in...';
        });

        // Cek session error
        @if (session('error'))
            let errorMessage = "{{ session('error') }}";
            let errorIcon = 'error';
            let errorTitle = 'Login Gagal';

            // Custom berdasarkan isi pesan
            switch (errorMessage) {
                case 'Pengguna tidak ditemukan.':
                    errorTitle = 'Akun Tidak Ditemukan';
                    break;
                case 'Password yang Anda masukkan salah.':
                    errorTitle = 'Password Salah';
                    break;
                case 'An error occurred. Please try again later.':
                    errorTitle = 'Kesalahan Server';
                    errorIcon = 'warning';
                    break;
                case 'Invalid credentials.':
                    errorTitle = 'Login Gagal';
                    break;
            }

            Swal.fire({
                icon: errorIcon,
                title: errorTitle,
                text: errorMessage,
                confirmButtonColor: '#d33'
            });
        @endif

        // Validasi gagal dari Laravel
        @if ($errors->any())
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += `• {{ $error }}\n`;
            @endforeach

            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: errorMessages,
                confirmButtonColor: '#f59e0b'
            });
        @endif
    </script>
@endpush

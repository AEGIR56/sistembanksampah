@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">{{ $user ? 'Edit Akun' : 'Tambah Akun' }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ $user ? route('admin.accounts.update', $user) : route('admin.accounts.store') }}">
                            @csrf
                            @if ($user)
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', $user->username ?? '') }}" required placeholder="Masukkan Username..">
                                @error('username')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email ?? '') }}" required placeholder="Masukkan Email..">
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select" required>
                                    <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>
                                        User</option>
                                    <option value="staff"
                                        {{ old('role', $user->role ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('role')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="phone_number" class="form-control"
                                    value="{{ old('phone_number', $user->phone_number ?? '') }}" required placeholder="Masukkan Nomor telepon..">
                                @error('phone_number')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password {{ $user ? '(isi jika ingin ubah)' : '' }}</label>
                                <input type="password" name="password" class="form-control" {{ $user ? '' : 'required' }} placeholder="{{ $user ? 'Isi jika ingin ubah' : 'Masukkan password..' }}">
                                @error('password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" {{ $user ? '' : 'required' }} placeholder="Konfirmasi Password">
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">{{ $user ? 'Update' : 'Simpan' }}</button>
                                <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

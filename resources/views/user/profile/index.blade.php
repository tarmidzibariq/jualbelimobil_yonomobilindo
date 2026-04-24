@extends('layouts.master')
@section('content')
<div class="app-content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title mb-0">Profil Pengguna</h3>
            </div>
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control bg-light"
                                value="{{ old('name', $user->name) }}"
                                readonly
                            >
                            <small class="text-muted">Nama tidak dapat diubah.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control bg-light"
                                value="{{ old('email', $user->email) }}"
                                readonly
                            >
                            <small class="text-muted">Email tidak dapat diubah.</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                Status WhatsApp:
                                @if($user->whatsapp_verified_at)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Verifikasi</span>
                                @endif
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                class="form-control @error('address') is-invalid @enderror"
                            >{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <p class="text-muted mb-3">Kosongkan password jika tidak ingin mengubah password.</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                            >
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="card mb-4" id="verifikasi">
            <div class="card-header">
                <h4 class="card-title mb-0">Verifikasi WhatsApp</h4>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    Verifikasi diperlukan sebelum melakukan transaksi. Kode OTP akan dikirim ke nomor WhatsApp Anda.
                </p>

                <form action="{{ route('user.profile.sendWhatsappOtp') }}" method="POST" class="mb-3 row g-2 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label for="phone_otp" class="form-label">Nomor WhatsApp</label>
                        <input
                            type="text"
                            id="phone_otp"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $user->phone) }}"
                            required
                        >
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            Kirim Kode OTP
                        </button>
                    </div>
                </form>

                <form action="{{ route('user.profile.verifyWhatsappOtp') }}" method="POST" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label for="otp_code" class="form-label">Masukkan Kode OTP</label>
                        <input
                            type="text"
                            id="otp_code"
                            name="otp_code"
                            maxlength="4"
                            class="form-control @error('otp_code') is-invalid @enderror"
                            placeholder="Contoh: 1234"
                            required
                        >
                        @error('otp_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">Verifikasi OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

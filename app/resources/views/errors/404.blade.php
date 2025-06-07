@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    {{-- <img src="{{asset('image/YONO-MOBILINDO-LOGO.svg')}}" alt="YONO MOBILINDO LOGO"> --}}
    <h1 class="display-4 text-danger">404</h1>
    <h3 class="mb-3">Halaman Tidak Ditemukan</h3>
    <p class="text-muted mb-4">Maaf, link yang Anda buka tidak tersedia atau sudah dipindahkan.</p>
    <a href="{{ route('home') }}" class="btn btn-login">Kembali ke Beranda</a>
</div>
@endsection

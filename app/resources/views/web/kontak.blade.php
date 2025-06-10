@extends('web.layouts.master')
@section('web-content')
@push('web-styles')
<style>
    #kontak {
        padding-top: 120px;
    }

</style>
@endpush

<section id="kontak">
    <div class="container py-5">
        <h3 class="fw-bold mb-5">
            Kontak Kami
        </h3>
        <div class="mb-2">
            <p class="mb-1 fw-semibold ">Lokasi</p>
            <p class="mb-0 ">Pekapuran Jl 1000 RT 06/05 NO 200 SUKAMAJU BARU
                TAPOS, DEPOK</p>
        </div>
        <div class="mb-2">
            <p class="mb-1 fw-semibold">Kontak</p>
            <p class="mb-0 ">081220745317</p>
        </div>
    </div>
</section>
@endsection

@extends('web.layouts.master')
@section('web-content')
@push('web-styles')
<style>
   

    #testimonial {
        padding-top: 120px;
        /* padding: 100px 0; */
        /* background: linear-gradient(to bottom, var(--background), var(--yellow)); */
    }

    #testimonial h5 {
        font-size: 18px;
        font-weight: 500;
    }

</style>
@endpush
<section id="testimonial">
    <div class="container py-5">
        <h3 class="text-center fw-bold mb-5">Apa Kata Pelanggan Kami</h3>
        <div class="row g-4 justify-content-center">
            <!-- Testimonial Card -->
             @forelse ($reviews as $review)
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{asset('storage/photo_review/' . $review->photo_review)}}" class="img-fluid" alt="Foto Pelanggan">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{$review->user->name}}</h5>
                            <div class="mb-2 text-warning">

                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                    
                                @endfor
                                
                            </div>
                            <p class="card-text text-muted" style="font-size: 14px;">
                                {{ $review->comment }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <h4 class="text-muted mb-3">Belum Ada Testimonial</h4>
                </div>
            @endforelse
        </div>

        {{-- <!-- Tombol -->
        <div class="text-end mt-4">
            <a href="#" class="text-dark  text-decoration-none d-inline-flex align-items-center">
                Lihat Yang Lain
                <span class="ms-2">→</span>
            </a>
        </div> --}}
    </div>

</section>
@endsection

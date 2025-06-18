@extends('layouts.master')
@section('content')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Testimoni Car</div>
            </div>
            <!--end::Header-->

            <!--begin::Error Alert-->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!--end::Error Alert-->

            <!--begin::Form-->
            <form action="{{ route('user.transactionSalesRecord.storeTesti', $salesRecord->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    {{-- Rating --}}
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1 - 5)</label>
                        <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating"
                            name="rating" min="1" max="5" value="{{ old('rating') }}" required>
                        @error('rating')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Comment --}}
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment"
                            name="comment" rows="3" required>{{ old('comment') }}</textarea>
                        @error('comment')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Photo Review --}}
                    <div class="mb-3">
                        <label for="photo_review" class="form-label">Foto Review</label>
                        <div class="mb-2">
                            <img id="preview-photo" src="#" alt="Preview Foto" style="max-height: 200px; object-fit: contain;"
                                class="img-thumbnail d-none">
                        </div>
                        <input type="file" class="form-control @error('photo_review') is-invalid @enderror"
                            id="photo_review" name="photo_review" onchange="previewImage(event, 'preview-photo')" required>
                        @error('photo_review')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Bukti Pembayaran Refund --}}
                    {{-- <div class="mb-3">
                        <label for="photo_review" class="form-label">Foto Review</label>
                        <div class="mb-2">
                            <img id="preview-refund" src="{" alt="Preview Bukti Refund"
                                style="max-height: 200px; object-fit: contain;" class="img-thumbnail">
                        </div>
                        <input type="file" class="form-control @error('photo_review') is-invalid @enderror"
                            id="photo_review" name="photo_review" onchange="previewImage(event)"
                            required>

                        @error('photo_review')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> --}}
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Container-->
</div>

@push('scripts')
<script>
function previewImage(event, previewId) {
    const input = event.target;
    const reader = new FileReader();
    reader.onload = function(){
        const imgElement = document.getElementById(previewId);
        imgElement.src = reader.result;
        imgElement.classList.remove('d-none');
    }
    reader.readAsDataURL(input.files[0]);
}
</script>

@endpush
@endsection

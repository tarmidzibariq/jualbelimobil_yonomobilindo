@extends('layouts.master')
@section('content')
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Refund #{{$downPayment->id}} </div>
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
            <form action="{{ route('admin.downPayment.storeRefund', $downPayment->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="mb-3">
                        <label for="no_rekening_refund" class="form-label">No Rekening User</label>
                        <textarea class="form-control @error('no_rekening_refund') is-invalid @enderror"
                            id="no_rekening_refund" name="no_rekening_refund"
                            required>{{ old('no_rekening_refund', $downPayment->refund ? $downPayment->refund->no_rekening_refund : '') }}
                        </textarea>
                        @error('no_rekening_refund')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="refund_payment_proof" class="form-label">Bukti Pembayaran Refund</label>
                        <div class="mb-2">
                        <img id="preview-refund" src="{{ $downPayment->refund && $downPayment->refund->refund_payment_proof 
                                    ? asset('storage/refund/' . $downPayment->refund->refund_payment_proof) 
                                    : asset('image/NoImage.png') }}"
                                alt="Preview Bukti Refund" style="max-height: 200px; object-fit: contain;"
                                class="img-thumbnail">
                        </div>
                        <input type="file" class="form-control @error('refund_payment_proof') is-invalid @enderror"
                            id="refund_payment_proof" name="refund_payment_proof" accept="image/*"
                            onchange="previewImage(event)" required>

                        @error('refund_payment_proof')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview-refund');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
@endpush
@endsection

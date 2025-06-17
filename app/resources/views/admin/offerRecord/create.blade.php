@extends('layouts.master')
@section('content')

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Transaction User Offer</div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.offerRecord.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    {{-- Buyer --}}
                    <div class="mb-3">
                        <label for="buyer_id" class="form-label">Buyer</label>
                        <select class="form-select @error('buyer_id') is-invalid @enderror" id="buyer_id"
                            name="buyer_id" required>
                            <option value="">-- Select Buyer --</option>
                            @foreach($users as $user)
                            

                            <option value="{{ $user->id }}"
                                {{ old('user_id', auth()->user()->id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('buyer_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Seller --}}
                    <div class="mb-3">
                        <label for="seller_id" class="form-label">Seller</label>
                        <select class="form-select @error('seller_id') is-invalid @enderror" id="seller_id"
                            name="seller_id" required>
                            <option value="">-- Select Seller --</option>
                            @foreach($users as $user)
                            @if(old('buyer_id') != $user->id) {{-- Exclude user yang sama dengan seller --}}
                            <option value="{{ $user->id }}" {{ old('seller_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('seller_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Car --}}
                    <div class="mb-3">
                        <label for="offer_id" class="form-label">Offer</label>
                        <select class="form-select @error('offer_id') is-invalid @enderror" id="offer_id" name="offer_id" required>
                            <option value="">-- Select Offer --</option>
                            @foreach($offers as $offer)
                            <option value="{{ $offer->id }}" data-price="{{ $offer->offered_price }}"
                                {{ old('offer_id') == $offer->id ? 'selected' : '' }}>
                                {{ $offer->brand }} {{ $offer->model }}
                            </option>
                            @endforeach
                        </select>
                        @error('offer_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Sale Price --}}
                    <div class="mb-3">
                        <label for="offered_price" class="form-label fw-medium">Sale Price</label>
                        <input type="text" class="form-control py-2 @error('offered_price') is-invalid @enderror"
                            id="offered_price_format"
                            value="{{ old('offered_price') ? number_format(old('offered_price'), 0, ',', '.') : '' }}" />

                        <input type="hidden" name="sale_price" id="offered_price" value="{{ old('offered_price') }}" />
                        @error('offered_price')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Sale Date --}}
                    <div class="mb-3">
                        <label for="sale_date" class="form-label">Sale Date</label>
                        <input type="date" class="form-control @error('sale_date') is-invalid @enderror" id="sale_date"
                            name="sale_date" value="{{ old('sale_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required />
                        @error('sale_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function formatRupiah(angka) {
        // Hapus karakter selain angka dan titik (untuk desimal)
        let numberString = angka.replace(/[^\d.]/g, "");

        // Pisahkan antara bagian sebelum dan sesudah koma (jika ada)
        let parts = numberString.split(".");

        // Ambil hanya bagian sebelum titik desimal
        let integerPart = parts[0];

        // Format ke rupiah (dengan titik setiap 3 digit)
        return integerPart ? 'Rp ' + integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Filter buyer options based on selected seller
        // Filter buyer options based on selected seller
        const sellerSelect = document.getElementById('seller_id');
        const buyerSelect = document.getElementById('buyer_id');

        function filterSellerOptions() {
            const selectedBuyer = buyerSelect.value;

            for (let option of sellerSelect.options) {
                option.hidden = false;
                if (option.value === selectedBuyer) {
                    option.hidden = true;
                }
            }

            // Jika buyer saat ini sama dengan seller, reset buyer
            if (sellerSelect.value === selectedBuyer) {
                sellerSelect.value = "";
            }
        }

        buyerSelect.addEventListener('change', filterSellerOptions);

        // Jalankan saat pertama kali load (jika ada old value)
        filterSellerOptions();

        const offerSelect = document.getElementById('offer_id');
        const priceInput = document.getElementById('offered_price');
        const inputFormatted = document.getElementById('offered_price_format');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            priceInput.value = clean;
        });

        function updatePrice() {
            const selectedOption = offerSelect.options[offerSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                priceInput.value = price;
                inputFormatted.value = formatRupiah(price);
            } else {
                priceInput.value = '';
                inputFormatted.value = '';
            }
        }

        offerSelect.addEventListener('change', updatePrice);
        updatePrice(); // Jalankan jika ada old value
    });
</script>
@endpush

@endsection

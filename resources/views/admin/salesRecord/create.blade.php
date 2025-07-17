@extends('layouts.master')
@section('content')

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Transaction Sales Record Car</div>
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
            <form action="{{ route('admin.salesRecord.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    {{-- Seller --}}
                    <div class="mb-3">
                        <label for="seller_id" class="form-label">Seller</label>
                        <select class="form-select @error('seller_id') is-invalid @enderror" id="seller_id"
                            name="seller_id" required>
                            <option value="">-- Select Seller --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', auth()->user()->id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('seller_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Buyer --}}
                    {{-- Buyer --}}
                    <div class="mb-3">
                        <label for="buyer_id" class="form-label">Buyer</label>
                        <select class="form-select @error('buyer_id') is-invalid @enderror" id="buyer_id"
                            name="buyer_id" required>
                            <option value="">-- Select Buyer --</option>
                            @foreach($users as $user)
                            @if(old('seller_id') != $user->id) {{-- Exclude user yang sama dengan seller --}}
                            <option value="{{ $user->id }}" {{ old('buyer_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('buyer_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Car --}}
                    <div class="mb-3">
                        <label for="car_id" class="form-label">Car</label>
                        <select class="form-select @error('car_id') is-invalid @enderror" id="car_id" name="car_id"
                            required>
                            <option value="">-- Select Car --</option>
                            @foreach($cars as $car)
                            <option value="{{ $car->id }}" data-price="{{ $car->price }}"
                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->model }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="sale_price" class="form-label fw-medium">Sale Price</label>
                        <input type="text" class="form-control py-2 @error('sale_price') is-invalid @enderror"
                            id="sale_price_format"
                            value="{{ old('sale_price') ? number_format(old('sale_price'), 0, ',', '.') : '' }}"
                            required />

                        <input type="hidden" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" />

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    {{-- Sale Date --}}
                    <div class="mb-3">
                        <label for="sale_date" class="form-label">Sale Date & Time</label>
                        <input type="datetime-local" 
                            class="form-control @error('sale_date') is-invalid @enderror" 
                            id="sale_date"
                            name="sale_date"
                            value="{{ old('sale_date', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                            required />
                        @error('sale_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>



                    {{-- Status --}}
                    {{-- <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="">-- Select Status --</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div> --}}
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
    // Format input offered_price to Rupiah
    function formatRupiah(angka) {
        let numberString = angka.replace(/\D/g, "");
        let formatted = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return numberString ? 'Rp ' + formatted : '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Filter buyer options based on selected seller
        const sellerSelect = document.getElementById('seller_id');
        const buyerSelect = document.getElementById('buyer_id');

        function filterBuyerOptions() {
            const selectedSeller = sellerSelect.value;

            for (let option of buyerSelect.options) {
                option.hidden = false;
                if (option.value === selectedSeller) {
                    option.hidden = true;
                }
            }

            // Jika buyer saat ini sama dengan seller, reset buyer
            if (buyerSelect.value === selectedSeller) {
                buyerSelect.value = "";
            }
        }

        sellerSelect.addEventListener('change', filterBuyerOptions);

        // Jalankan saat pertama kali load (jika ada old value)
        filterBuyerOptions();

        // Update sale_price based on selected car
        const carSelect = document.getElementById('car_id');
        const priceInput = document.getElementById('sale_price');
        const inputFormatted = document.getElementById('sale_price_format');
        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            priceInput.value = clean;
        });

        function updatePrice() {
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                priceInput.value = price;
                inputFormatted.value = formatRupiah(price);
            } else {
                priceInput.value = '';
            }
        }

        carSelect.addEventListener('change', updatePrice);

        // Jika sebelumnya sudah terisi (old input), jalankan sekali
        updatePrice();
    });

</script>

@endpush

@endsection

@extends('layouts.master')
@section('content')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Create New Stock Car </div>
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
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control select2 @error('user_id') is-invalid @enderror " name="user_id" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($user as $u)
                                <option value="{{ $u->id }}"
                                    {{ old('user_id', auth()->user()->id) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select name="brand" id="brand" class="form-control" required>
                            <option value="">-- Pilih Brand --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                        
                        @error('brand')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <select name="model" id="model" class="form-control" required disabled>
                            <option value="">-- Pilih Model --</option>
                        </select>
                        @error('model')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-control select2Year @error('year') is-invalid @enderror" name="year" id="year" required>
                            <option value="">-- Pilih Tahun --</option>
                            @for ($year = 2025; $year >= 2004; $year--)
                                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('year')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price_format" class="form-label">Price</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price_format"
                               value="{{ old('price') ? number_format(old('price'), 0, ',', '.') : '' }}" required />
                    
                        <input type="hidden" name="price" id="price" value="{{ old('price') }}" />
                    
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <select name="transmission" id="transmission" class="form-control @error('transmission') is-invalid @enderror" required>
                            <option value="">-- Pilih Transmission --</option>
                            <option value="automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                        @error('transmission')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea cols="10" rows="2" class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="service_history" class="form-label">Last Service</label>
                        <input type="date" class="form-control @error('service_history') is-invalid @enderror"
                            id="service_history" name="service_history" value="{{ old('service_history') }}" required />
                        @error('service_history')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type</label>
                        <input type="text" class="form-control @error('fuel_type') is-invalid @enderror"
                            id="fuel_type" name="fuel_type" value="{{ old('fuel_type') }}" required />
                        @error('fuel_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input type="number" class="form-control @error('mileage') is-invalid @enderror" id="mileage"
                            name="mileage" value="{{ old('mileage') }}" required />
                        @error('mileage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sale_type" class="form-label">Sale Type</label>
                        <select name="sale_type" id="sale_type" class="form-control @error('sale_type') is-invalid @enderror" required>
                            <option value="">-- Pilih sale_type --</option>
                            <option value="showroom" {{ old('sale_type') == 'Showroom' ? 'selected' : '' }}>Showroom</option>
                            <option value="user" {{ old('sale_type') == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('sale_type')
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
      $('.select2').select2({
          theme: 'bootstrap-5',
          placeholder: "-- Pilih User --",
          allowClear: true
      });
      $('.select2Year').select2({
          theme: 'bootstrap-5',
          placeholder: "-- Pilih Tahun --",
          allowClear: true
      });

      $('#brand, #model').select2({
        theme: 'bootstrap-5',
        width: '100%',
        allowClear: true,
    });

    $('#brand').on('change', function () {
        const brand = $(this).val();
        $('#model').prop('disabled', true).empty().append('<option value="">Loading...</option>');

        if (brand) {
            $.get('/api/models', { brand: brand }, function (data) {
                $('#model').empty().append('<option value="">-- Pilih Model --</option>');
                $.each(data, function (i, model) {
                    $('#model').append(`<option value="${model}">${model}</option>`);
                });
                $('#model').prop('disabled', false).trigger('change');
            });
        } else {
            $('#model').empty().append('<option value="">-- Pilih Model --</option>').prop('disabled', true);
        }
    });

  });

//   Format input price to Rupiah
  function formatRupiah(angka) {
        return angka.replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputFormatted = document.getElementById('price_format');
        const inputHidden = document.getElementById('price');

        inputFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputHidden.value = clean;
        });
    });

</script>
@endpush

@endsection

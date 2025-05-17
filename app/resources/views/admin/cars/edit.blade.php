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
                <div class="card-title">Edit #{{ $car->id }} Stock Car </div>
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
            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-control select2 @error('user_id') is-invalid @enderror" name="user_id" required>
                          <option value="">-- Pilih User --</option>
                          @foreach ($user as $u)
                              <option value="{{ $u->id }}"
                                  {{ old('user_id', $car->user_id) == $u->id ? 'selected' : '' }}>
                                  {{ $u->name }} ({{ $u->email }})
                              </option>
                          @endforeach
                      </select>
                        @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select name="brand" id="brand" class="form-control" required>
                            <option value="">-- Pilih Brand --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand }}" {{ old('brand', $car->brand) == $brand ? 'selected' : '' }}>{{ $brand }}</option>
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
                                <option value="{{ $year }}" {{ old('year', $car->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
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
                               value="{{ old('price', $car->price) ? number_format(old('price',$car->price), 0, ',', '.') : '' }}" required />
                    
                        <input type="hidden" name="price" id="price" value="{{ old('price',$car->price) }}" />
                    
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{-- {{ dd($car->transmission) }} --}}
                    <div class="mb-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <select name="transmission" id="transmission" class="form-control select2 @error('transmission') is-invalid @enderror" required>
                            <option value="">-- Pilih Transmission --</option>
                            <option value="automatic" {{ old('transmission', $car->transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="manual" {{ old('transmission', $car->transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
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
                            id="description" name="description" required>{{ old('description',$car->description) }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="service_history" class="form-label">Last Service</label>
                        <input type="date" class="form-control @error('service_history') is-invalid @enderror"
                            id="service_history" name="service_history" value="{{ old('service_history', $car->service_history) }}" required />
                        @error('service_history')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type</label>
                        <input type="text" class="form-control @error('fuel_type') is-invalid @enderror"
                            id="fuel_type" name="fuel_type" value="{{ old('fuel_type', $car->fuel_type) }}" required />
                        @error('fuel_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="mileage" class="form-label">Mileage</label>
                        <input type="text" class="form-control @error('mileage') is-invalid @enderror" id="mileage_format"
                            value="{{ old('mileage',$car->mileage) ? number_format(old('mileage',$car->mileage), 0, ',', '.') : '' }}" required />
                 
                        <input type="hidden" name="mileage" id="mileage" value="{{ old('mileage',$car->mileage) }}" />
                    
                        @error('mileage')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="sale_type" class="form-label">Sale Type</label>
                        <select name="sale_type" id="sale_type" class="form-control select2 @error('sale_type') is-invalid @enderror" required>
                            <option value="">-- Pilih sale_type --</option>
                            <option value="showroom" {{ old('sale_type',$car->sale_type) == 'showroom' ? 'selected' : '' }}>Showroom</option>
                            <option value="user" {{ old('sale_type',$car->sale_type) == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('sale_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div id="photo-wrapper" class="row">
                        <label for="sale_type" class="form-label">Photo Cars</label>
                        @if ($car->carPhoto->count())
                            <div class="row mb-3">
                                @foreach ($car->carPhoto as $photo)
                                <div class="col-md-4 text-center">
                                    @if (Storage::disk('public')->exists('car_photos/' . $photo->photo_url))
                                    <img src="{{ asset('storage/car_photos/' . $photo->photo_url) }}"
                                        alt="Car Photo"
                                        class="img-fluid rounded shadow-sm mb-2"
                                        style="max-height: 180px;">

                                    <form action="{{ route('admin.carsPhoto.destroy', $photo->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger w-100 btn-remove-photo">
                                            <i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                    
                                    @else
                                    <p class="text-danger fw-bold">
                                        File Terhapus, Silahkan upload ulang.
                                    </p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Belum ada foto yang diunggah.</p>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between mt-2">
                        <button type="button" id="btn-add-photo" class="btn btn-info px-4">Add Photo</button>
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
    const selectedModel = @json(old('model', $car->model));
    const selectedBrand = @json(old('brand', $car->brand));

    $(document).ready(function() {
        $('.select2, .select2Year').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: '-- Pilih --',
        
        });
        $('#brand, #model').select2({
            theme: 'bootstrap-5',
            width: '100%',
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        function loadModelOptions(brand, selectedModel = null) {
            if (!brand) {
                $('#model').empty().append('<option value="">-- Pilih Model --</option>').prop('disabled', true);
                return;
            }

            $('#model').prop('disabled', true).empty().append('<option value="">Loading...</option>');

            $.get('/api/models', { brand: brand }, function (data) {
                $('#model').empty().append('<option value="">-- Pilih Model --</option>');
                $.each(data, function (i, model) {
                    const selected = (model === selectedModel) ? 'selected' : '';
                    $('#model').append(`<option value="${model}" ${selected}>${model}</option>`);
                });
                $('#model').prop('disabled', false).trigger('change');
            });
        }

        // ⏳ Load saat halaman dibuka jika brand sudah terisi
        if (selectedBrand) {
            loadModelOptions(selectedBrand, selectedModel);
        }

        // 🔁 Load ulang saat brand diubah
        $('#brand').on('change', function () {
            const brand = $(this).val();
            loadModelOptions(brand);
        });

    });

    // Format input price to Rupiah
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

        const inputMileageFormatted = document.getElementById('mileage_format');
        const inputMileageHidden = document.getElementById('mileage');
    
        inputMileageFormatted.addEventListener('input', function () {
            let clean = this.value.replace(/\D/g, "");
            this.value = formatRupiah(clean);
            inputMileageHidden.value = clean;
        });
    });
    // Menangani penambahan dan penghapusan foto
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('photo-wrapper');
        const btnAdd = document.getElementById('btn-add-photo');

        // Fungsi untuk preview
        function previewImage(input, previewElement) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewElement.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Tambah field baru
        btnAdd.addEventListener('click', function () {
            const newCol = document.createElement('div');
            newCol.classList.add('col-md-4', 'mb-4', 'photo-group');

            newCol.innerHTML = `
                <div class="border rounded p-3 shadow-sm position-relative text-center h-100">
                    <img src="{{ asset('image/NoImage.png') }}" class="img-preview img-fluid mb-3" style="max-height: 150px;" />
                    <input type="file" name="photos[]" class="form-control photo-input mb-2" accept="image/*" required>
                    <button type="button" class="btn btn-danger w-100 btn-remove-photo">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            `;
            wrapper.appendChild(newCol);
        });

        // Delegasi untuk preview dan hapus
        wrapper.addEventListener('change', function (e) {
            if (e.target.classList.contains('photo-input')) {
                const img = e.target.closest('.photo-group').querySelector('.img-preview');
                previewImage(e.target, img);
            }
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-photo')) {
                const group = e.target.closest('.photo-group');
                group.remove();
            }
        });
    });
</script>

@endpush

@endsection

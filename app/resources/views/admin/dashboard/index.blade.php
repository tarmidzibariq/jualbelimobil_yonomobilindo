@extends('layouts.master')
@section('content')

@push('styles')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">

@endpush
<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <!--begin::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{$downPayment}}</h3>
                        <p>Down Payment Status Confirmed</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z" />
                    </svg>

                    <a href="{{ route('admin.downPayment.index', ['status' => 'payment:confirmed']) }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{$offer}}</h3>
                        <p>Permintaan Penjualan Status Pending</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                    </svg>
                    <a href="{{ route('admin.offer.index', ['status' => 'pending']) }}"
                        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <div class="col-lg-4 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{$car}}</h3>
                        <p>Mobil Terjual</p>
                    </div>

                    <svg class="small-box-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 640 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M171.3 96L224 96l0 96-112.7 0 30.4-75.9C146.5 104 158.2 96 171.3 96zM272 192l0-96 81.2 0c9.7 0 18.9 4.4 25 12l67.2 84L272 192zm256.2 1L428.2 68c-18.2-22.8-45.8-36-75-36L171.3 32c-39.3 0-74.6 23.9-89.1 60.3L40.6 196.4C16.8 205.8 0 228.9 0 256L0 368c0 17.7 14.3 32 32 32l33.3 0c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80l130.7 0c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80l33.3 0c17.7 0 32-14.3 32-32l0-48c0-65.2-48.8-119-111.8-127zM434.7 368a48 48 0 1 1 90.5 32 48 48 0 1 1 -90.5-32zM160 336a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                        </svg>
                    <a href="{{ route('admin.cars.index', ['status' => 'sold'] ) }}"
                        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
                <!--end::Small Box Widget 3-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-6 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Total Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <div id="transaction-count-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 connectedSortable">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Jumlah Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <div id="sales-amount-chart"></div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Appointment</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
            {{-- End Col --}}
        </div>
        <!-- /.row (main row) -->
    </div>
    <!-- Modal kosong, akan diisi konten AJAX -->
        <div class="modal fade" id="downPaymentModal" tabindex="-1" aria-labelledby="downPaymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="downPaymentModalContent">
                    <!-- Konten modal akan di-load via AJAX -->
                    <div class="modal-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--end::Container-->
</div>
<!--end::App Content-->

@push('scripts')
{{-- Jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- apexcharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

<!-- ChartJS -->
<script>
    // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
    // IT'S ALL JUST JUNK FOR DEMO
    // ++++++++++++++++++++++++++++++++++++++++++
    const months = @json($months);
    const salesCountData = @json($salesCountSeries);
    const salesAmountData = @json($salesAmountSeries);
    const offerCountData = @json($offerCountSeries);
    const offerAmountData = @json($offerAmountSeries);

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
    const transactionCountOptions = {
        series: [
            { name: 'Catatan Transaksi Pembelian', data: salesCountData },
            { name: 'Catatan Transaksi Penjualan', data: offerCountData },
        ],
        chart: { type: 'area', height: 300 },
        xaxis: { type: 'datetime', categories: months },
        tooltip: {
            // y: {
            //     formatter: formatRupiah
            // },
            x: {
                format: 'MMMM yyyy'
            }
        }
    };

    new ApexCharts(document.querySelector('#transaction-count-chart'), transactionCountOptions).render();

     const salesAmountOptions = {
        series: [
            { name: 'Catatan Transaksi Pembelian', data: salesAmountData },
            { name: 'Catatan Transaksi Penjualan', data: offerAmountData },
        ],
        chart: { type: 'area', height: 300 },
        xaxis: { type: 'datetime', categories: months },
        tooltip: {
            y: {
                formatter: formatRupiah
            },
            x: {
                format: 'MMMM yyyy'
            }
        }
    };

    new ApexCharts(document.querySelector('#sales-amount-chart'), salesAmountOptions).render();


</script>

<script>
     function showDownPaymentDetail(id) {
        let modal = new bootstrap.Modal(document.getElementById('downPaymentModal'));
        let modalContent = $('#downPaymentModalContent');

        modalContent.html(`
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

        modal.show();

        $.ajax({
            url: `/admin/downPayment/${id}`,
            method: 'GET',
            success: function (response) {
                modalContent.html(response);
            },
            error: function () {
                modalContent.html(
                    '<div class="modal-body text-danger">Failed to load data.</div>'
                );
            }
        });
    }

    $(document).ready(function () {
        // Tombol di tabel
        $('.btn-show-detail').on('click', function () {
            let downPaymentId = $(this).data('id');
            showDownPaymentDetail(downPaymentId);
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: @json($appointments),
            eventClick: function(info) {
                // Panggil modal detail sesuai sumber
                const eventId = info.event.id;
                const source = info.event.extendedProps.source;

                if (source === 'downpayment') {
                    showDownPaymentDetail(eventId.replace('dp-', ''));
                } else if (source === 'offer') {
                    window.open(info.event.url, '_blank');
                    info.jsEvent.preventDefault();
                }

                info.jsEvent.preventDefault();
            },
            locale: 'id',
            nowIndicator: true,
            height: 650
        });

        calendar.render();
    });


</script>

@endpush
@endsection

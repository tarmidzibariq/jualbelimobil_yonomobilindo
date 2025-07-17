<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\DownPayment;
use App\Models\Offer;
use App\Models\OfferRecord;
use App\Models\SalesRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkrole:admin');
    }
    public function index()
    {
    // < START FITUR STATISTIK>
        // Menghitung jumlah down payment dengan status confirmed 
        $downPayment = DownPayment::where('payment_status', 'confirmed')
            // ->where('created_at', '>=', now()->subDays(30))
            ->whereNull('refund_id')
            ->count();

        // Menghitung jumlah permintaan penjualan dengan status pending 
        $offer = Offer::where('status', 'pending')
            // ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Menghitung jumlah mobil terjual
        $car = Car::where('status', 'sold')
            ->count();
    // < END FITUR STATISTIK>

    // <START FITUR GRAFIK>
        // Range: 7 bulan terakhir
        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Ambil bulan terakhir 7 bulan (string YYYY-MM-01)
        $months = collect(range(0, 6))->map(function ($i) {
            return Carbon::now()->subMonths(6 - $i)->format('Y-m-01');
        });

        // SALES_RECORDS: ambil COUNT & SUM per bulan
        $salesData = SalesRecord::selectRaw("DATE_FORMAT(sale_date, '%Y-%m-01') as month, COUNT(*) as count, SUM(sale_price) as total")
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $salesAmountData = SalesRecord::selectRaw("DATE_FORMAT(sale_date, '%Y-%m-01') as month, SUM(sale_price) as total")
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // OFFER_RECORDS: ambil COUNT & SUM per bulan
        $offerData =OfferRecord::selectRaw("DATE_FORMAT(sale_date, '%Y-%m-01') as month, COUNT(*) as count, SUM(sale_price) as total")
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $offerAmountData =OfferRecord::query()
            ->selectRaw("DATE_FORMAT(sale_date, '%Y-%m-01') as month, SUM(sale_price) as total")
            ->whereBetween('sale_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Normalize: isi 0 kalau data kosong
        $salesCountSeries = $months->map(fn($month) => $salesData[$month] ?? 0);
        $salesAmountSeries = $months->map(fn($month) => $salesAmountData[$month] ?? 0);

        $offerCountSeries = $months->map(fn($month) => $offerData[$month] ?? 0);
        $offerAmountSeries = $months->map(fn($month) => $offerAmountData[$month] ?? 0);
    // < END FITUR GRAFIK>

    // <START FITUR TANGGAL> 
        // DOWN PAYMENTS
        $downPayments = DownPayment::with('user')
            // ->where('appointment_date', '>=', now()->subMonths(1))
            ->whereNotNull('appointment_date')
            ->where('payment_status', 'confirmed')
            ->whereNull('refund_id') // Pastikan tidak ada refund
            ->orderBy('appointment_date')
            ->get()
            ->map(function ($item) {
                return [
                    'id'      => 'dp-' . $item->id,
                    'title'   => 'DP: ' . $item->user->name . ' - Rp' . number_format($item->amount, 0, ',', '.'),
                    'start'   => $item->appointment_date->format('Y-m-d\TH:i:s'),
                    'color'   => '#DC2525', // MERAH
                    'source'  => 'downpayment',
                ];
            });

        // OFFERS
        $offers = Offer::with('user')
            // ->where('inspection_date', '>=', now()->subMonths(1))
            ->whereNotNull('inspection_date')
            ->where('status', 'accepted')
            ->orderBy('inspection_date')
            ->get()
            ->map(function ($item) {
                return [
                    'id'      => 'offer-' . $item->id,
                    'title'   => 'Offer: ' . $item->user->name . ' - ' . $item->brand . ' ' . $item->model,
                    'start'   => $item->inspection_date->format('Y-m-d\TH:i:s'),
                    'color'   => '#20c997', // HIJAU
                    'source'  => 'offer',
                    'url'     => route('admin.offer.show', $item->id), // URL untuk detail offer
                ];
            });

        // Gabungkan jadi satu array
        $appointments = $downPayments->merge($offers)->values();
    // <END FITUR TANGGAL>
        return view('admin.dashboard.index', [
            'downPayment'  => $downPayment,
            'offer'        => $offer,
            'car'          => $car,
            'months'             => $months->values(),
            'salesCountSeries'   => $salesCountSeries->values(),
            'salesAmountSeries'  => $salesAmountSeries->values(),
            'offerCountSeries'   => $offerCountSeries->values(),
            'offerAmountSeries'  => $offerAmountSeries->values(),
            'appointments' => $appointments,
        ]);

    }
}

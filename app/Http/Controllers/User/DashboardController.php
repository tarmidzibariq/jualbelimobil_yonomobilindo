<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use App\Models\Offer;
use App\Models\OfferRecord;
use App\Models\SalesRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $downPayment = DownPayment::with('car') // kalau relasi ke Car
            ->where('payment_status', 'pending')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        
        $offers = Offer::where('status', 'accepted')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')->get();
        // dd($offers);

        $salesRecord = SalesRecord::where('buyer_id', Auth::id())
            ->where('status', 'completed')
            ->count();
        $offerRecord = OfferRecord::where('seller_id', Auth::id())
            ->where('status', 'completed')
            ->count();
            // dd($salesRecord);
        return view('user.dashboard.index', compact('downPayment', 'offers', 'salesRecord', 'offerRecord'));
    }
}

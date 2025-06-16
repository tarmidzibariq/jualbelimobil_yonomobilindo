<?php

namespace App\Http\Controllers\User;

use App\Helpers\MidtransHelper;
use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $downPayments = DownPayment::with('car')->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

        return view('user.downPayment.index', compact('downPayments'));   
    }
    

    public function checkout($id){
        
        $downPayments = DownPayment::with('car')->where('user_id', Auth::id())->findOrFail($id);
        return view('user.downPayment.checkout', compact('downPayments'));
    }

    // public function getSnapToken($id)
    // {
    //     $dp = DownPayment::findOrFail($id);

    //     // Optional: pastikan hanya pemilik DP yang bisa generate token-nya
    //     if ($dp->user_id !== auth()->id()) {
    //         abort(403, 'Unauthorized');
    //     }

    //     // Set konfigurasi Midtrans (seharusnya sudah di AppServiceProvider)
    //     Config::$serverKey = config('midtrans.server_key');
    //     Config::$isProduction = false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $params = [
    //         'transaction_details' => [
    //             'order_id' => 'DP-' . $dp->id . '-' . uniqid(),
    //             'gross_amount' => (int) $dp->amount,
    //         ],
    //         'customer_details' => [
    //             'first_name' => auth()->user()->name,
    //             'email' => auth()->user()->email,
    //         ]
    //     ];

    //     try {
    //         $snapToken = Snap::getSnapToken($params);
    //         return response()->json(['snapToken' => $snapToken]);
    //     } catch (\Exception $e) {
    //         \Log::error('Midtrans Error: ' . $e->getMessage());
    //         return response()->json(['error' => 'Gagal generate token'], 500);
    //     }
    // }

}

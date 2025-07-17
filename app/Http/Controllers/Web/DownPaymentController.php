<?php

namespace App\Http\Controllers\Web;

use App\Helpers\MidtransHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\DownPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class DownPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'user') {
            return redirect()->back()->with('error', 'Admin tidak diperbolehkan melakukan pembayaran DP.');
        }
        // Validasi input
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'amount' => 'required|numeric|min:500000',
            'car_id' => 'required|exists:cars,id',
        ]);

        $car = Car::findOrFail($request->car_id);
        
        // Gabungkan tanggal dan waktu
        $appointmentDateTime = $request->appointment_date . ' ' . $request->appointment_time;

        // Jika kolom di database `appointment_date` bertipe DATETIME
        // Maka konversi ke format datetime valid (pakai Carbon)
        $appointmentDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $appointmentDateTime);

        // Simpan data ke tabel (misal DownPayment)
        $store = DownPayment::create([
            'car_id' => $car->id,
            'user_id' => Auth::guard('web')->id(),
            'appointment_date' => $appointmentDateTime,
            'amount' => $request->amount,
        ]);

        $store->save();

        // return redirect()->route('home-cms')->with('success', 'DP berhasil dikirim.');
        return redirect()->route('user.downPayment.checkout' , $store->id);
    }

    public function show($id){

        $car = Car::with('mainPhoto')->findOrFail($id);
        
        if ($car->status == "available") {
            return view('web.downPayment', compact('car'));
        }else{
            return  view('errors.404');
        }
    }

    private function goToPaymentView($id) {
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        // Konfigurasi Midtrans
        MidtransHelper::init();

        $orderId = 'DP-' . $downPayment->id . '-' . time();

        // Siapkan parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,  
                'gross_amount' => (int) $downPayment->amount,
            ],
            'customer_details' => [
                'first_name' => $downPayment->user->name,
                'email' => $downPayment->user->email,
                'phone' => $downPayment->user->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        DownPayment::where('id', $id)
        ->where('payment_status', 'pending')
        ->update(['order_id' => $orderId]);

        return view('user.downPayment.checkout', [
            'downPayments' => $downPayment,
            'snapToken' => $snapToken
        ]);
    }
}

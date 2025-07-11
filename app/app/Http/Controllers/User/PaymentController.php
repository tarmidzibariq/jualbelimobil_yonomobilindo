<?php

namespace App\Http\Controllers\User;

use App\Helpers\MidtransHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\DownPayment;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    // Menampilkan halaman Snap pembayaran
    public function checkout($id)
    {
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        $car = Car::findOrFail($downPayment->car_id);
        // dd($car->status);
        // Cek apakah mobil sudah terjual
        if ($car->status === 'sold' || $car->status === 'under_review' || $car->status === 'pending_check') {
            return redirect()->back()->with('error', 'Mobil ini sudah terjual.');
        }

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

    public function changeStatus($id) {   
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);
        
        MidtransHelper::init();

        $statusFromMidtrans = Transaction::status($downPayment->order_id);
        $transaction = $statusFromMidtrans->transaction_status ?? "pending";
        // dd($transaction);
        
        $status = "pending";
        $paymentMethod = null;

        if ($transaction == 'settlement') {
            $status = 'confirmed';
            $paymentMethod = $statusFromMidtrans->payment_type ?? null; 
        } elseif ($transaction == 'expire') {
            $status = 'expired';
        }elseif ($transaction == 'cancel') {
            $status = 'cancelled';
        } elseif ($transaction == 'pending') {
            $status = 'pending';
        }

        DownPayment::where("id", $id)
            ->update([
                "payment_status" => $status,
                "payment_date" => $statusFromMidtrans->transaction_time ?? null,
                "payment_method" => $paymentMethod,
            ]);
        
        if ($status == 'confirmed') {
            // Update status mobil menjadi sold
            $downPayment->car->update(['status' => 'under_review']);
        }

        $newDownPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        return view('user.downPayment.checkout', [
            'downPayments' => $newDownPayment,
            'snapToken' => ""
        ]);
    }

    // Webhook Midtrans
    public function notificationHandler(Request $request)
    {
        Log::info('Webhook Midtrans MASUK:', $request->all());

        try {
            $notif = new Notification();
            $transaction = $notif->transaction_status;
            $orderId = $notif->order_id;

            // Format order_id = DP-5-1718000000
            $id = explode('-', $orderId)[1] ?? null;
            $payment = DownPayment::find($id);

            if (!$payment) {
                Log::error("❌ DownPayment ID {$id} tidak ditemukan.");
                return response()->json(['message' => 'Not found'], 404);
            }

            // Proses status dari Midtrans
            if ($transaction == 'settlement') {
                $payment->payment_status = 'confirmed';
                $payment->payment_date = now();
            } elseif ($transaction == 'expire') {
                $payment->payment_status = 'cancelled';
            } elseif ($transaction == 'pending') {
                $payment->payment_status = 'pending';
            }

            $payment->save();
            Log::info("✅ Status untuk ID {$id} diupdate menjadi {$payment->payment_status}");

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            Log::error('🔥 ERROR Webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Error handling notification'], 500);
        }
    }
}

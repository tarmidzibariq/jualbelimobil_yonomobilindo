<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DownPayment;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Menampilkan halaman Snap pembayaran
    public function checkout($id)
    {
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Siapkan parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'DP-' . $downPayment->id . '-' . time(),
                'gross_amount' => (int) $downPayment->amount,
            ],
            'customer_details' => [
                'first_name' => $downPayment->user->name,
                'email' => $downPayment->user->email,
                'phone' => $downPayment->user->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('user.downPayment.checkout', [
            'downPayments' => $downPayment,
            'snapToken' => $snapToken
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

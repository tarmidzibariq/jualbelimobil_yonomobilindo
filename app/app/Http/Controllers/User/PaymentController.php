<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DownPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function getSnapToken($id)
    {
        
        $dp = DownPayment::findOrFail($id);

        // Optional: pastikan hanya pemilik DP yang bisa generate token-nya
        if ($dp->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Set konfigurasi Midtrans (seharusnya sudah di AppServiceProvider)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        
        $params = [
            'transaction_details' => [
                'order_id' => 'DP-' . $dp->id . '-' . uniqid(),
                'gross_amount' => (int) $dp->amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal generate token'], 500);
        }
    }

    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans callback received', $payload);

        $orderId = explode('-', $payload['order_id'])[1] ?? null;

        $dp = DownPayment::find($orderId);
        if (!$dp) return response()->json(['message' => 'Not found'], 404);

        if ($payload['transaction_status'] === 'settlement' || $payload['transaction_status'] === 'capture') {
            $dp->payment_status = 'confirmed';
        } elseif (in_array($payload['transaction_status'], ['cancel', 'deny', 'expire'])) {
            $dp->payment_status = 'cancelled';
        } else {
            $dp->payment_status = 'pending';
        }

        $dp->save();

        return response()->json(['message' => 'OK']);
    }

}

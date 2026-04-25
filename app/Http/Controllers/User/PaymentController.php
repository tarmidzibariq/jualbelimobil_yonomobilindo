<?php

namespace App\Http\Controllers\User;

use App\Helpers\MidtransHelper;
use App\Helpers\WhatsAppHelper;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\DownPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    // Menampilkan halaman Checkout untuk pembayaran DP
    public function checkout($id)
    {
        if (!Auth::user()?->whatsapp_verified_at) {
            return redirect()->route('user.profile.index')
                ->with('error', 'Sebelum transaksi, verifikasi nomor WhatsApp Anda terlebih dahulu.');
        }

        DownPayment::cancelExpiredPendingPayments();

        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        if ($downPayment->payment_status !== 'pending') {
            return redirect()->route('user.downPayment.index')
                ->with('error', 'Pembayaran ini sudah tidak aktif (dibatalkan, kedaluwarsa, atau sudah dibayar).');
        }

        MidtransHelper::init();

        if (in_array($downPayment->car->status, ['under_review', 'sold', 'pending_check']) && $downPayment->payment_status === 'pending') {
            $downPayment->update([
                'payment_status' => 'cancelled',
                'snap_token' => null,
                'pending_payment_expires_at' => null,
            ]);

            return redirect()->route('user.downPayment.index')
                ->with('error', 'Pembayaran dibatalkan karena mobil sudah dibayar pengguna lain.');
        }

        // Cek status order lama dulu
        if ($downPayment->order_id) {
            try {
                $midtransStatus = Transaction::status($downPayment->order_id);

                $transaction = $midtransStatus->transaction_status ?? null;

                if ($transaction === 'settlement') {
                    $wasConfirmed = $downPayment->payment_status === 'confirmed';

                    $downPayment->update([
                        'payment_status' => 'confirmed',
                        'payment_date' => $midtransStatus->transaction_time,
                        'payment_method' => $midtransStatus->payment_type,
                        'snap_token' => null,
                        'pending_payment_expires_at' => null,
                    ]);

                    $downPayment->car->update(['status' => 'under_review']);
                    $this->cancelOtherPendingDownPayments($downPayment);

                    if (!$wasConfirmed) {
                        $this->sendPaymentConfirmedWhatsApp($downPayment);
                    }

                    return redirect()->route('user.downPayment.show', $id)
                        ->with('success', 'Pembayaran berhasil!');
                } elseif ($transaction === 'expire' || $transaction === 'cancel') {
                    $downPayment->update([
                        'payment_status' => $transaction === 'expire' ? 'expired' : 'cancelled',
                        'snap_token' => null,
                        'pending_payment_expires_at' => null,
                    ]);
                } elseif ($transaction === 'pending') {
                    if (empty($downPayment->snap_token)) {
                        $newOrderId = 'DP-' . $downPayment->id . '-' . time();
                        $params = [
                            'transaction_details' => [
                                'order_id' => $newOrderId,
                                'gross_amount' => (int) $downPayment->amount,
                            ],
                            'customer_details' => [
                                'first_name' => $downPayment->user->name,
                                'email' => $downPayment->user->email,
                                'phone' => $downPayment->user->phone,
                            ],
                        ];

                        $downPayment->update([
                            'order_id' => $newOrderId,
                            'snap_token' => Snap::getSnapToken($params),
                            'pending_payment_expires_at' => now()->addMinutes(10),
                        ]);
                        $downPayment->refresh();
                    }

                    // masih pending → pakai snap_token lama
                    return view('user.downPayment.checkout', [
                        'downPayments' => $downPayment,
                        'snapToken' => $downPayment->snap_token,
                    ]);
                }
            } catch (\Throwable $e) {
                // fallback → buat order baru
            }
        }

        // Jika belum ada order atau sudah expire/cancel
        $orderId = 'DP-' . $downPayment->id . '-' . time();

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

        $downPayment->update([
            'order_id' => $orderId,
            'snap_token' => $snapToken,
            'payment_status' => 'pending',
            'pending_payment_expires_at' => now()->addMinutes(10),
        ]);

        return view('user.downPayment.checkout', [
            'downPayments' => $downPayment,
            'snapToken' => $snapToken,
        ]);
    }


    public function changeStatus($id) {
        if (!Auth::user()?->whatsapp_verified_at) {
            return redirect()->route('user.profile.index')
                ->with('error', 'Sebelum transaksi, verifikasi nomor WhatsApp Anda terlebih dahulu.');
        }

        DownPayment::cancelExpiredPendingPayments();

        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        if ($downPayment->payment_status !== 'pending') {
            return redirect()->route('user.downPayment.index')
                ->with('error', 'Pembayaran ini sudah tidak aktif (dibatalkan, kedaluwarsa, atau sudah dibayar).');
        }

        MidtransHelper::init();

        if (in_array($downPayment->car->status, ['under_review', 'sold', 'pending_check']) && $downPayment->payment_status === 'pending') {
            $downPayment->update([
                'payment_status' => 'cancelled',
                'snap_token' => null,
                'pending_payment_expires_at' => null,
            ]);

            return redirect()->route('user.downPayment.index')
                ->with('error', 'Pembayaran dibatalkan karena mobil sudah dibayar pengguna lain.');
        }

        $statusFromMidtrans = null;

        try {
            $statusFromMidtrans = Transaction::status($downPayment->order_id);
        } catch (\Throwable $th) {
        }

        $transaction = $statusFromMidtrans->transaction_status ?? "pending";

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

        if ($transaction != 'pending') {
            DownPayment::where("id", $id)
            ->update([
                "payment_status" => $status,
                "payment_date" => $statusFromMidtrans->transaction_time ?? null,
                "payment_method" => $paymentMethod,
                'snap_token' => null,
                'pending_payment_expires_at' => null,
            ]);
        }else {
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

            $snapToken = !empty($downPayment->snap_token) ? $snapToken = $downPayment->snap_token : $snapToken = Snap::getSnapToken($params);

            DownPayment::where('id', $id)
            ->where('payment_status', 'pending')
            ->update([
                'order_id' => $orderId,
                'snap_token' => $snapToken,
                'pending_payment_expires_at' => now()->addMinutes(10),
            ]);

            $newDownPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

            return view('user.downPayment.checkout', [
                'downPayments' => $newDownPayment,
                'snapToken' => $snapToken
            ]);
        }
        
        if ($status == 'confirmed') {
            $wasConfirmed = $downPayment->payment_status === 'confirmed';

            // Update status mobil menjadi sold
            $downPayment->car->update(['status' => 'under_review']);
            $this->cancelOtherPendingDownPayments($downPayment);

            if (!$wasConfirmed) {
                $this->sendPaymentConfirmedWhatsApp($downPayment);
            }
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
        MidtransHelper::init();
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

            $wasConfirmed = $payment->payment_status === 'confirmed';

            // Proses status dari Midtrans
            $status = "pending";
            $paymentMethod = null;

            if ($transaction == 'settlement') {
                $status = 'confirmed';
                $paymentMethod = $data['payment_type'] ?? null; 
            } elseif ($transaction == 'expire') {
                $status = 'expired';
            }elseif ($transaction == 'cancel') {
                $status = 'cancelled';
            } elseif ($transaction == 'pending') {
                $status = 'pending';
            }
    
            $updatePayload = [
                "payment_status" => $status,
                "payment_date" => $notif->transaction_time ?? null,
                "payment_method" => $paymentMethod,
            ];
            if ($status !== 'pending') {
                $updatePayload['pending_payment_expires_at'] = null;
            }
            DownPayment::where("id", $id)->update($updatePayload);

            $payment->save();

            if ($status === 'confirmed' && !$wasConfirmed) {
                $payment->car?->update(['status' => 'under_review']);
                $this->cancelOtherPendingDownPayments($payment);
                $this->sendPaymentConfirmedWhatsApp($payment->fresh(['user', 'car']));
            }

            Log::info("✅ Status untuk ID {$id} diupdate menjadi {$payment->payment_status}");

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            Log::error('🔥 ERROR Webhook: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkMidtransStatus($id)
    {
        $downPayment = DownPayment::with('user')->findOrFail($id);  
        
        // dd($downPayment);
        $car = Car::findOrFail($downPayment->car_id);
        if ($car->status === 'sold' || $car->status === 'under_review' || $car->status === 'pending_check') {
            return response()->json(['status' => $car->status], 200);
        }

        $serverKey = config('services.midtrans.server_key');
        $encodedKey = base64_encode($serverKey . ':');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Basic ' . $encodedKey
        ])->get("https://api.sandbox.midtrans.com/v2/{$downPayment->order_id}/status");

        if ($response->successful()) {
            $data = $response->json();

            // dd($data);

            $transaction = $data['transaction_status'] ?? null;
            $paymentMethod = $data['payment_type'] ?? null;

            // Midtrans pending biasanya status_code 201.
            $status = match ($transaction) {
                'settlement' => 'confirmed',
                'expire' => 'expired',
                'cancel' => 'cancelled',
                'pending' => 'pending',
                default => 'unknown',
            };

            if ($status !== 'unknown') {
                $updatePayload = [
                    "payment_status" => $status,
                    "payment_date" => $data['transaction_time'] ?? null,
                    "payment_method" => $paymentMethod,
                ];

                // Simpan snap_token saat pending agar popup pembayaran bisa dibuka lagi.
                if ($status !== 'pending') {
                    $updatePayload['pending_payment_expires_at'] = null;
                    $updatePayload['snap_token'] = null;
                } elseif (empty($downPayment->snap_token)) {
                    $newOrderId = 'DP-' . $downPayment->id . '-' . time();
                    $params = [
                        'transaction_details' => [
                            'order_id' => $newOrderId,
                            'gross_amount' => (int) $downPayment->amount,
                        ],
                        'customer_details' => [
                            'first_name' => $downPayment->user->name ?? '-',
                            'email' => $downPayment->user->email ?? '-',
                            'phone' => $downPayment->user->phone ?? '-',
                        ],
                    ];
                    $updatePayload["order_id"] = $newOrderId;
                    $updatePayload["snap_token"] = Snap::getSnapToken($params);
                    $updatePayload['pending_payment_expires_at'] = now()->addMinutes(10);
                }

                DownPayment::where("id", $id)->update($updatePayload);
                $downPayment->refresh();

                return response()->json([
                    'status' => $status,
                    'snap_token' => $downPayment->snap_token
                ]);
            }

            return response()->json(
                [
                    'status' => 'error',
                    'snap_token' => $downPayment->snap_token
                ],
                $response->status()
            );
        }

        DownPayment::where("id", $id)
            ->update([
                'snap_token' => null
        ]);

        return response()->json(['status' => 'error'], $response->status());
    }

    private function sendPaymentConfirmedWhatsApp(DownPayment $downPayment): void
    {
        $downPayment->loadMissing(['user', 'car']);

        if (!$downPayment->user) {
            return;
        }

        $carName = trim(($downPayment->car->brand ?? '') . ' ' . ($downPayment->car->model ?? ''));
        $amount = number_format((float) $downPayment->amount, 0, ',', '.');

        WhatsAppHelper::send(
            $downPayment->user->phone ?? null,
            "Halo {$downPayment->user->name}, pembayaran DP sebesar Rp {$amount} untuk mobil {$carName} sudah kami terima. Terima kasih.",
            [
                'event' => 'payment_confirmed',
                'down_payment_id' => $downPayment->id,
                'user_id' => $downPayment->user_id,
            ]
        );
    }

    private function cancelOtherPendingDownPayments(DownPayment $confirmedDownPayment): void
    {
        DownPayment::where('car_id', $confirmedDownPayment->car_id)
            ->where('id', '!=', $confirmedDownPayment->id)
            ->where('payment_status', 'pending')
            ->update([
                'payment_status' => 'cancelled',
                'snap_token' => null,
                'payment_method' => null,
                'pending_payment_expires_at' => null,
            ]);
    }
}

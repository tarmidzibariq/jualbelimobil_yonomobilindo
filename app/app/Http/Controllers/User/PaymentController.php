<?php

namespace App\Http\Controllers\User;

use App\Helpers\MidtransHelper;
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
        // Menampilkan halaman Snap pembayaran
    public function checkout($id)
    {
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

        // $car = Car::findOrFail($downPayment->car_id);
        // // dd($car->status);

        // // Cek apakah mobil sudah terjual
        //  if ($car->status !== 'available') {
        //     return redirect()->route('user.downPayment.index')->with('error', 'Mobil tidak tersedia untuk pembayaran.');
        // }
        
        // Konfigurasi Midtrans
        MidtransHelper::init();

        $checkStatus = $this->checkMidtransStatus($id);
        // dd($checkStatus);
        if ($checkStatus->original['status'] != "error") {
            $this->changeStatus($id);
        }

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
            'snap_token' => $snapToken
        ]);

        return view('user.downPayment.checkout', [
            'downPayments' => $downPayment,
            'snapToken' => $snapToken
        ]);
    }

    public function changeStatus($id) {
        $downPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);
        
        MidtransHelper::init();

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
                'snap_token' => null
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
                'snap_token' => $snapToken
            ]);

            $newDownPayment = DownPayment::with(['user', 'car'])->where('user_id', Auth::id())->findOrFail($id);

            return view('user.downPayment.checkout', [
                'downPayments' => $newDownPayment,
                'snapToken' => $snapToken
            ]);
        }
        
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
    
            DownPayment::where("id", $id)
                ->update([
                    "payment_status" => $status,
                    "payment_date" => $notif->transaction_time ?? null,
                    "payment_method" => $paymentMethod,
                ]);

            $payment->save();
            Log::info("✅ Status untuk ID {$id} diupdate menjadi {$payment->payment_status}");

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            Log::error('🔥 ERROR Webhook: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function checkMidtransStatus($id)
    {
        $downPayment = DownPayment::findOrFail($id);  
        
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

            // Convert status Midtrans ke sistem lokal (optional)
            if ($data["status_code"] == 200) {
                $status = match ($data['transaction_status']) {
                    'settlement' => 'confirmed',
                    'expire' => 'cancelled',
                    'pending' => 'pending',
                    default => 'unknown',
                };

                $transaction = $data['transaction_status'];

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
        
                DownPayment::where("id", $id)
                    ->update([
                        "payment_status" => $status,
                        "payment_date" => $data['transaction_time'] ?? null,
                        "payment_method" => $paymentMethod,
                        "snap_token" => null
                    ]);
    
                return response()->json(['status' => $status]);
            }else {
                $id = DownPayment::where("id", $id)
                ->update([
                    'snap_token' => null
                ]);

            // dd($id);

            return response()->json(
                [
                    'status' => 'error',
                    'snap_token' => $downPayment->snap_token
                ], 
                $response->status());
            }
        }

        DownPayment::where("id", $id)
            ->update([
                'snap_token' => null
        ]);

        return response()->json(['status' => 'error'], $response->status());
    }
}

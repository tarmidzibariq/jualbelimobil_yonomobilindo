<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownPayment extends Model
{
    use HasFactory;

    /** Maksimum DP berstatus pending per user (belum dibayar / menunggu). */
    public const MAX_PENDING_PER_USER = 2;

    protected $fillable = [
        'user_id',
        'car_id',
        'amount',
        'appointment_date',
        'payment_status',
        'payment_date',
        'pending_payment_expires_at',
        // 'payment_proof',
        'order_id',
        'snap_token',
        'payment_method',
        'refund_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'appointment_date' => 'datetime',
        'pending_payment_expires_at' => 'datetime',
    ];

    /**
     * Batalkan DP pending yang melewati batas waktu pembayaran (tanpa melakukan hit ke Midtrans).
     */
    public static function cancelExpiredPendingPayments(): int
    {
        return self::where('payment_status', 'pending')
            ->whereNotNull('pending_payment_expires_at')
            ->where('pending_payment_expires_at', '<=', now())
            ->update([
                'payment_status' => 'cancelled',
                'snap_token' => null,
                'payment_method' => null,
                'pending_payment_expires_at' => null,
            ]);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Car model
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
    // Define the relationship with the Refund model
    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }
}

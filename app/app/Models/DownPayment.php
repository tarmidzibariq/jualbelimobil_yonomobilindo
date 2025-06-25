<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'amount',
        'appointment_date',
        'payment_status',
        'payment_date',
        // 'payment_proof',
        'order_id',
        'snap_token',
        'payment_method',
        'refund_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'appointment_date' => 'datetime',
    ];

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

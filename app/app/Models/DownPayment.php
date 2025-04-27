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
        'payment_status',
        'payment_date',
        'appointment_date',
        'payment_proof',

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
}

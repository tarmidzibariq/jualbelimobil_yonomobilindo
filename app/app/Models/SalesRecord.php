<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'buyer_id',
        'seller_id',
        'sale_price',
        'sale_date',
        'status',

    ];

    // Define the relationship with the Car model
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

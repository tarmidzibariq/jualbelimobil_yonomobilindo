<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferRecord extends Model
{
    protected $fillable = [
        'offer_id',
        'buyer_id',
        'seller_id',
        'sale_price',
        'sale_date',
        'status',

    ];

    // Define the relationship with the Car model
    public function offer()
    {
        return $this->belongsTo(Car::class);
    }

    // Define the relationship with the User model
    public function buyerOfferRecord()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    
    public function salerOfferRecord()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}

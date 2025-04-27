<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use hasFactory;

    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'mileage',
        'condition',
        'offered_price',
        'status',
        'inspection_date',
    ];


    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 

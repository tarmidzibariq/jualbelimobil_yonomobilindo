<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CarPhoto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car_id',
        'photo_url',
    ];

    // defining the relationship with the Car model
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

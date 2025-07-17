<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sales_record_id',
        'car_id',
        'rating',
        'comment',
        'photo_review',
        'status', 
    ];

    // defining the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // defining the relationship with the Car model    
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    // defining the relationship with the SalesRecord model
    public function salesRecord()
    {
        return $this->belongsTo(SalesRecord::class);
    }
}

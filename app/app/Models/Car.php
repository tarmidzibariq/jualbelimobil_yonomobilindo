<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'price',
        'mileage',
        'color',
        'description',
        'user_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Sales model
    public function salesRecords()
    {
        return $this->hasMany(SalesRecord::class);
    }

    // Define the relationship with the DownPayment model
    public function downPayment()
    {
        return $this->hasMany(DownPayment::class);
    }

    // Define the relationship with the reviews model
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    // Define the relationship with the Car_Photo model
    public function carPhoto()
    {
        return $this->hasMany(CarPhoto::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'price',
        'transmission',
        'description',
        'service_history',
        'fuel_type',
        'mileage',
        'color',
        'tax',
        'engine',
        'seat',
        'bpkb',
        'spare_key',
        'manual_book',
        'service_book',
        'sale_type',
        'status',
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
        // return $this->hasMany(SalesRecord::class);
        return $this->hasOne(SalesRecord::class);
    }

    // Define the relationship with the DownPayment model
    public function downPayment()
    {
        return $this->hasMany(DownPayment::class);
    }

    // Define the relationship with the reviews model
    public function review()
    {
        // return $this->hasMany(Review::class);
        return $this->hasOne(Review::class);
    }

    // Define the relationship with the Car_Photo model
    public function carPhoto()
    {
        return $this->hasMany(CarPhoto::class)->orderBy('number');
    }
    // Relasi khusus untuk foto utama
    public function mainPhoto()
    {
        return $this->hasOne(CarPhoto::class)->orderBy('number', 'asc');
    }
}

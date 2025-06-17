<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Define the relationship with the Offer model
    public function offer()
    {
        return $this->hasMany(Offer::class);
    }

    // Define the relationship with the Car model
    public function car()
    {
        return $this->hasMany(Car::class);
    }

    // Define the relationship with the Sales_Record model
    // public function salesRecord()
    // {
    //     return $this->hasMany(SalesRecord::class);
    // }

    // Define the relationship with the SalesRecord model
    public function purchases()
    {
        return $this->hasMany(SalesRecord::class, 'buyer_id');
    }
    public function sales()
    {
        return $this->hasMany(SalesRecord::class, 'seller_id');
    }

    // Define the relationship with the OfferRecord model
    public function purchasesOfferRecord()
    {
        return $this->hasMany(OfferRecord::class, 'buyer_id');
    }
    public function salesOfferRecord()
    {
        return $this->hasMany(OfferRecord::class, 'seller_id');
    }

    // Define the relationship with the DownPayment model
    public function downPayment()
    {
        return $this->hasMany(DownPayment::class);
    }

    // Define the relationship with the Review model
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

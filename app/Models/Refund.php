<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'no_rekening_refund',
        'refund_status',
        'refund_payment_proof',
    ];

    public function downPayment()
    {
        return $this->hasOne(DownPayment::class);
    }
}

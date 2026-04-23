<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpKode extends Model
{
    protected $fillable = [
        'kode',
        'user_id',
        'phone',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Otp extends Model
{
    protected $table = 'otps';

    protected $fillable = [
        'identifier',
        'otp_code',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public $timestamps = true;
    
    public function isValid(string $inputOtp): bool
    {
        return $this->otp_code === $inputOtp && Carbon::now()->lt($this->expires_at);
    }
}

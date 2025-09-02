<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    //
    protected $fillable = ['user_name','phone','address','payment_voucher','payment_type','order_code','final_total'];
}

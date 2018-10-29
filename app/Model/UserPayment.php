<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    //
    protected $fillable = [
      'payment_type', 'status', 'actual_amount', 'user_id'
    ];
}

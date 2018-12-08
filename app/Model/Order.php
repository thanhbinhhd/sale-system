<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const HANDLED = 1;
    const PENDING = 0;
    //
    protected $fillable = [
      'user_id', 'quantity', 'sub_total',
        'total', 'status', 'note'
    ];

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}

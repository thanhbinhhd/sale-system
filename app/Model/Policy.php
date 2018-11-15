<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    //
    const ACTIVE = 1;
    const BLOCKED = 0;
    
    protected $fillable = [
        'vat', 'money_type', 'admin_id', 'status'
    ];

    protected $dates = [
      'start_date', 'end_date'
    ];


    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

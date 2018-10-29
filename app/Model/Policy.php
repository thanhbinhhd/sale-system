<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    //
    protected $fillable = [
        'vat', 'money_type', 'admin_id'
    ];
}

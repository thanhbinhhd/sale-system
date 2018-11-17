<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'tagable_id', 'tagable_type'
    ];

    public function tagable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Model;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
	public static function boot()
	{
		parent::boot();

       static::addGlobalScope(new StatusScope());
	}

    protected $fillable = [
      'title', 'link', 'status'
    ];

}

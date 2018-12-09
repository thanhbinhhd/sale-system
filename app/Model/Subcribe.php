<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\sendSubscribeNotification;
use Illuminate\Notifications\Notifiable;

class Subcribe extends Model
{
	use Notifiable;
	//
	protected $fillable = [
		'email'
	];

	public function sendSubscribeNotification($title, $description, $blogSlug) {
        $this->notify(new sendSubscribeNotification($title, $description, $blogSlug));
    }
}

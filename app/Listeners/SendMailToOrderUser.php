<?php

namespace HapoJC\Listeners;

use App\Events\AddOrder;
use App\Model\User;
use App\Notifications\AddNewOrderNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailToOrderUser
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  AddOrder  $event
	 * @return void
	 */
	public function handle(AddOrder $event)
	{
		dd($event);
		$subUsers = $event->subUsers;
		foreach ($subUsers as $subUser) {
			$user = User::findOrFail($subUser->id);
			$user->notify(new AddNewOrderNotification($subUser->token));
		}
	}

}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class AddNewOrderNotification extends Notification
{
	use Queueable;

	protected $order;
	protected $user;
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */

	public function __construct($order, $user)
	{
		//
		$this->order = $order;
		$this->user = $user;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->line(Lang::getFromJson('You are receiving this email because you ordered some products in my website by this email.'))
			->action(Lang::getFromJson('Go to website'), route('shop',['category' =>'All'] ))
			->line(Lang::getFromJson('Your order has been processed and will be shipped within a short period of time.'))
			->view('user.mail.accept-order', [

			])
			->line(Lang::getFromJson('Thank you for using our service.'));
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class sendSubscribeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $title;
    public $description;
    public $blogSlug;
    public function __construct($title, $description, $blogSlug)
    {
        $this->title = $title;
        $this->description = $description;
        $this->blogSlug = $blogSlug;
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
            ->line(Lang::getFromJson('New Blog : '.$this->title))
            ->line(Lang::getFromJson('Description: '.$this->description))
            ->action(Lang::getFromJson('Go to Blog'), route('user.blog', ['blogSlug' => $this->blogSlug]));
    }

}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewBansNotification extends Notification
{
    use Queueable;

    private $list;
    private $accounts;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($list, $accounts)
    {
        $this->list = $list;
        $this->accounts = $accounts;
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
            ->subject('New bans were found on list 〜 ' . $this->list->name)
            ->markdown('mail.new_bans', [
                'list' => $this->list,
                'accounts' => $this->accounts,
            ]);
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

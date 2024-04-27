<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBansNotification extends Notification
{
    private $list;
    private $accounts;

    /**
     * Create a new notification instance.
     */
    public function __construct($list, $accounts)
    {
        $this->list = $list;
        $this->accounts = $accounts;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
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
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

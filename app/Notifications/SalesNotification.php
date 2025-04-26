<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Notifications\SmsChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable)
    {
        return (new SmsMessage)
            ->from('Netway')
            ->to($notifiable->phone)
            ->line("You have just made a purchase from Akota Pharmacy");
    }
}

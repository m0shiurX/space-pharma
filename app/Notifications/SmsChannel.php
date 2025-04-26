<?php

namespace App\Notifications;

use App\Notifications\SalesNotification;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, SalesNotification $notification)
    {
        $message = $notification->toSms($notifiable);
        $message->send();
    }
}

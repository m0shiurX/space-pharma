<?php

namespace App\Notifications;

class SmsChannel
{
    public function send($notifiable, SalesNotification $notification)
    {
        $message = $notification->toSms($notifiable);
        $message->send();
    }
}

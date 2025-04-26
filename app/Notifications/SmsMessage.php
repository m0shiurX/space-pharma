<?php

namespace App\Notifications;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SmsMessage
{

    protected string $user;
    protected string $password;
    protected string $to;
    protected string $from;
    protected array $lines;

    public function __construct($lines = [])
    {
        $this->lines = $lines;

        $this->from = config('services.ubernetSMS.from');
        $this->baseUrl = config('services.ubernetSMS.base_url');
        $this->api_key = config('services.ubernetSMS.api_key');
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function send()
    {
        if (!$this->from || !$this->to || !count($this->lines)) {
            throw new \Exception('SMS not correct.');
        }

        return Http::post(
            $this->baseUrl,
            [
                'api_key' => $this->api_key,
                "type" => "text",
                'senderid' => $this->from,
                'contacts' => $this->to,
                'msg' => implode(' ', $this->lines),
            ]
        );
    }
}

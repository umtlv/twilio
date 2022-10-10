<?php

namespace Umtlv\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Twilio
{
    private $twilio;
    private $from;

    /**
     * @throws ConfigurationException
     */
    public function __construct($sid, $token, $from)
    {
        $this->twilio = new Client($sid, $token);
        $this->from = $from;
    }

    /**
     * @throws TwilioException
     */
    public function sendSms($to, $message)
    {
        $this->twilio->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}
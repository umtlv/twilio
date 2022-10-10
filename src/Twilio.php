<?php

namespace Umtlv\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

class Twilio
{
    private $twilio;
    private $from;

    /**
     * @throws ConfigurationException
     */
    public function __construct($key, $secret, $sid, $from)
    {
        $this->twilio = new Client($key, $secret, $sid);
        $this->from = $from;
    }

    /**
     * @param $to
     * @param $message
     * @return MessageInstance
     * @throws TwilioException
     */
    public function sendSms($to, $message)
    {
        return $this->twilio->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }
}
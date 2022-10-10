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
    private $US = true;

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
        if (!$this->isValidNumber($to)) {
            throw new ConfigurationException("Incorrect number");
        }

        return $this->twilio->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }

    /**
     * @throws TwilioException
     */
    private function isValidNumber($to)
    {
        if (empty($to)) return false;

        if ($this->US && !preg_match('/^\+[1-9]\d{1,14}$/', $to))
            return false;

        $lookup = $this->twilio->lookups->v1->phoneNumbers($to);
        $number = $lookup->fetch(["type" => ["carrier"]])->toArray();

        if ($number['carrier']['type'] === 'mobile')
            return true;

        return false;
    }

    public function notOnlyUS()
    {
        $this->US = false;
    }
}
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
    private $countryCodes = ["US"];

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
            throw new TwilioException("Incorrect number");
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

        $lookup = $this->twilio->lookups->v2->phoneNumbers($to);
        $number = $lookup->fetch(["type" => ["carrier"]]);

        if (empty($number->toArray())) return false;

        if (!in_array($number->countryCode, $this->countryCodes)) {
            return false;
        }

        return $number->valid;
    }

    /**
     * @throws TwilioException
     */
    public function updateCountryCodes($countryCodes)
    {
        if (!is_array($countryCodes)) {
            throw new TwilioException("List of countries must be in array");
        }

        $this->countryCodes = $countryCodes;
    }
}

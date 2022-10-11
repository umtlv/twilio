<?php

namespace Umtlv\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class Twilio
{
    private $twilio;
    private $from;
    private $countryCodes;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $key = config('twilio.key');
        $secret = config('twilio.key');
        $sid = config('twilio.key');
        $this->from = config('twilio.from');
        $this->countryCodes = config('twilio.country_codes');

        if (
            is_null($key) ||
            is_null($secret) ||
            is_null($sid) ||
            is_null($this->from) ||
            empty($this->countryCodes)
        ) {
            throw new ConfigurationException('Configurations are incorrect');
        }

        $this->twilio = new Client($key, $secret, $sid);
    }

    /**
     * @param $to
     * @param $message
     * @throws TwilioException
     */
    public function sendSms($to, $message)
    {
        if (empty($to)) {
            throw new TwilioException("Recipient is not specified");
        }

        if (empty($message)) {
            throw new TwilioException("Message is not specified");
        }

        if (!$this->isValidNumber($to)) {
            throw new TwilioException("Incorrect number");
        }

        if (!empty($from)) {
            $this->from = $from;
        }

        $this->twilio->messages->create($to, [
            'from' => $this->from,
            'body' => $message
        ]);
    }

    /**
     * @throws TwilioException
     */
    private function isValidNumber($to): bool
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
}

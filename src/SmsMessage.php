<?php

namespace Umtlv\Twilio;

use Twilio\Exceptions\TwilioException;

class SmsMessage
{
    protected $from = null;
    protected $message;
    protected $to;

    public function from($from): SmsMessage
    {
        $this->from = $from;

        return $this;
    }

    public function to($to): SmsMessage
    {
        $this->to = $to;

        return $this;
    }

    public function message($message = ''): SmsMessage
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @throws TwilioException
     */
    public function send(Twilio $twilio)
    {
        $twilio->sendSms($this->to, $this->message, $this->from);
    }
}
<?php

namespace Anam\SmsVerification\Notifications\Messages;

use Illuminate\Notifications\Messages\SimpleMessage;

class SmsMessage extends SimpleMessage
{
    protected $messageBody = '';

    public function getMessageBody(): string
    {
        foreach ($this->introLines as $line) {
            $this->messageBody .= $line . "\n";
        }

        return trim($this->messageBody, "\n");
    }
}

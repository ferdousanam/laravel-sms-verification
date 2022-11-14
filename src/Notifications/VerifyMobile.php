<?php

namespace Anam\SmsVerification\Notifications;

use Anam\SmsVerification\Notifications\Messages\SmsMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class VerifyMobile extends Notification
{
    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return array_keys(config('sms-verification.sms-channels'));
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return SmsMessage
     */
    public function toSms($notifiable)
    {
        $verificationOtp = $this->verificationOtp($notifiable);

        return $this->buildSmsMessage($verificationOtp);
    }

    /**
     * Get the verify mobile notification mail message for the given OTP.
     *
     * @param string $otp
     * @return SmsMessage
     */
    protected function buildSmsMessage($otp)
    {
        return (new SmsMessage)
            ->line(Lang::get('Please enter the OTP to verify your mobile number.'))
            ->line(Lang::get('Your One Time Password (OTP) is ' . $otp . '.'))
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationOtp($notifiable)
    {
        return $notifiable->createVerificationToken()->token;
    }
}

<?php

namespace Anam\SmsVerification;

use Anam\SmsVerification\Notifications\VerifyMobileNumber;

trait MustVerifyMobileNumber
{
    /**
     * Initialize the has must verify mobile trait for an instance.
     *
     * @return void
     */
    public function initializeMustVerifyMobileNumber()
    {
        if (!$this->isFillable($this->getMobileNumberColumn())) {
            $this->mergeFillable([$this->getMobileNumberColumn()]);
        }
    }

    /**
     * Get the name of the "mobile_number" column.
     *
     * @return string
     */
    public function getMobileNumberColumn()
    {
        return defined('static::MOBILE_NUMBER') ? static::MOBILE_NUMBER : 'mobile_number';
    }

    /**
     * Get the fully qualified "mobile_number" column.
     *
     * @return string
     */
    public function getQualifiedMobileNumberColumn()
    {
        return $this->qualifyColumn($this->getMobileNumberColumn());
    }

    /**
     * Get the name of the "mobile_number_verified_at" column.
     *
     * @return string
     */
    public function getMobileNumberVerifiedAtColumn()
    {
        return defined('static::MOBILE_NUMBER_VERIFIED_AT') ? static::MOBILE_NUMBER_VERIFIED_AT : 'mobile_number_verified_at';
    }

    /**
     * Get the fully qualified "mobile_number_verified_at" column.
     *
     * @return string
     */
    public function getQualifiedMobileNumberVerifiedAtColumn()
    {
        return $this->qualifyColumn($this->getMobileNumberVerifiedAtColumn());
    }

    /**
     * Determine if the user has verified their mobile address.
     *
     * @return bool
     */
    public function hasVerifiedMobileNumber()
    {
        return ! is_null($this->{$this->getMobileNumberVerifiedAtColumn()});
    }

    /**
     * Mark the given user's mobile number as verified.
     *
     * @return bool
     */
    public function markMobileNumberAsVerified()
    {
        return $this->forceFill([
            $this->getMobileNumberVerifiedAtColumn() => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the mobile number verification notification.
     *
     * @return void
     */
    public function sendMobileNumberVerificationNotification()
    {
        $this->notify(new VerifyMobileNumber);
    }

    /**
     * Get the mobile number that should be used for verification.
     *
     * @return string
     */
    public function getMobileNumberForVerification()
    {
        return $this->{$this->getMobileNumberColumn()};
    }
}

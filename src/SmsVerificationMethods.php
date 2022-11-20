<?php

namespace Anam\SmsVerification;

class SmsVerificationMethods
{
    /**
     * Register the typical authentication routes for an application.
     *
     * @return callable
     */
    public function smsVerification()
    {
        return function ($options = []) {
            $namespace = class_exists($this->prependGroupNamespace('Auth\LoginController')) ? null : 'App\Http\Controllers';

            $this->group(['namespace' => $namespace], function() use($options) {
                // SMS Verification Routes...
                if ($options['verify_mobile'] ??
                    class_exists($this->prependGroupNamespace('Auth\MobileNumberVerificationController'))) {
                    $this->get('sms/verify', 'Auth\MobileNumberVerificationController@show')->name('sms-verification.notice');
                    $this->post('sms/verify', 'Auth\MobileNumberVerificationController@verify')->name('sms-verification.verify');
                    $this->post('sms/resend', 'Auth\MobileNumberVerificationController@resend')->name('sms-verification.resend');
                }
            });
        };
    }
}

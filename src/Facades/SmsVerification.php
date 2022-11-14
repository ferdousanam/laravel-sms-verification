<?php

namespace Anam\SmsVerification\Facades;

use Anam\SmsVerification\SmsVerificationServiceProvider;
use Illuminate\Support\Facades\Facade;
use RuntimeException;

/**
 * @see \Illuminate\Contracts\Auth\StatefulGuard
 */
class SmsVerification extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms-verification';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     *
     * @throws \RuntimeException
     */
    public static function routes(array $options = [])
    {
        if (! static::$app->providerIsLoaded(SmsVerificationServiceProvider::class)) {
            throw new RuntimeException('In order to use the MobileVerification::routes() method, please install the ferdousanam/laravel-sms-verification package.');
        }

        static::$app->make('router')->smsVerification($options);
    }
}

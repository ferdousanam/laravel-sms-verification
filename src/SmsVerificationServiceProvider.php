<?php

namespace Anam\SmsVerification;

use Anam\SmsVerification\Commands\ChannelsCommand;
use Anam\SmsVerification\Commands\ControllersCommand;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SmsVerificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ControllersCommand::class,
                ChannelsCommand::class,
            ]);
            $this->publishes([
                __DIR__ . '/../config/sms-verification.php' => config_path('sms-verification.php'),
            ], 'sms-verification');
            $this->publishes([
                __DIR__ . '/../stubs/migrations/create_verification_tokens_table.php' => database_path('migrations/' . date('Y_m_d_His') . '_create_verification_tokens_table.php'),
            ], 'sms-verification-migrations');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/sms-verification.php', 'sms-verification');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::mixin(new SmsVerificationMethods);

        $this->app->afterResolving(ChannelManager::class, function (ChannelManager $channels) {
            foreach ($this->app['config']['sms-verification.sms-channels'] as $key => $channel) {
                $channels->extend($key, function ($app) use ($channel) {
                    /* @var Application $app */
                    return $app->make($channel['driver']);
                });
            }
        });

        $this->loadViewsFrom(__DIR__ . '/../views', 'sms-verification');
    }
}

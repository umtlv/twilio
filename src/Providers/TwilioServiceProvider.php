<?php

namespace Umtlv\Twilio\Providers;

use Illuminate\Support\ServiceProvider;
use Umtlv\Twilio\Console\InstallCommand;

class TwilioServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class
            ]);

            $this->publishes([
                __DIR__ . '/../../config/twilio.php' => config_path('twilio.php'),
            ], 'twilio-config');
        }
    }
}
<?php

namespace Tutexpsoft\Oauth2redis;

use Illuminate\Support\ServiceProvider;
use Tutexpsoft\Oauth2redis\Console\KeysCommand;

class TutexpOauth2RedisServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //


        if ($this->app->runningInConsole()) {
            $this->commands([
                KeysCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

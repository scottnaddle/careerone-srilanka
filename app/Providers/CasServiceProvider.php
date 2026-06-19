<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use phpCAS;

class CasServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        phpCAS::client(
            CAS_VERSION_2_0,
            env('CAS_HOSTNAME'),
            443,
            '/cas',
            env('CAS_CLIENT_SERVICE')
        );

        phpCAS::setNoCasServerValidation();

        // Do not call setServerLoginURL here
        $this->app->singleton('cas.loginUrl', function () {
            $locale = app()->getLocale();
            return sprintf(
                'https://%s/cas/login?locale=%s&service=%s',
                env('CAS_HOSTNAME'),
                urlencode($locale),
                urlencode(env('CAS_CLIENT_SERVICE1'))
            );
        });
    }

    public function boot(): void
    {
        //
    }
}

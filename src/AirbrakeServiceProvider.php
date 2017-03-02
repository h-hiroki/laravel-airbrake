<?php

namespace adamtester\laravelairbrake;

use Airbrake\Notifier;
use Illuminate\Support\ServiceProvider;

class AirbrakeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/airbrake.php' => config_path('airbrake.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // check enable
        if (!config('airbrake.enabled')) {
            return;
        }

        $this->app->singleton('Airbrake\Instance', function ($app) {
            $airbrake = new Notifier([
                'projectId'  => config('airbrake.id'),
                'projectKey' => config('airbrake.key'),

                'host' => config('airbrake.host'),
            ]);

            $airbrake->addFilter(function ($notice) {
                $this->setEnvName($notice);

                foreach ($this->getEnvKeys() as $envKey) {
                    $this->filterEnvKey($notice, $envKey);
                }

                if (in_array($notice['errors'][0]['type'], config('airbrake.ignore_exceptions'))) {
                    // Ignore this exception.
                    return null;
                }

                return $notice;
            });

            return $airbrake;
        });

        $handler = $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler');
        $this->app->instance(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            new Handler\AirbrakeExceptionHandler($handler, $this->app)
        );
    }

    protected function filterEnvKey(&$notice, $envKey)
    {
        if (isset($notice['environment'][$envKey])) {
            $notice['environment'][$envKey] = 'FILTERED';
        }
    }

    protected function getEnvFile()
    {
        $filePath = $this->app->environmentPath().'/'.$this->app->environmentFile();

        $envFile = @file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return is_array($envFile) ? $envFile : [];
    }

    protected function getEnvKeyFromLine($envLine)
    {
        return trim(current(explode('=', $envLine)));
    }

    protected function getEnvKeys()
    {
        $envFile = $this->getEnvFile();

        $envKeys = array_map([$this, 'getEnvKeyFromLine'], $envFile);

        return $envKeys;
    }

    protected function setEnvName(&$notice)
    {
        $notice['context']['environment'] = env('APP_ENV');
    }
}

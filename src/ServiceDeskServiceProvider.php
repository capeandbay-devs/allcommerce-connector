<?php

namespace CapeAndBay\AllCommerce;

use Illuminate\Support\ServiceProvider;

class ServiceDeskServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServiceDesk();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->runningInConsole()) {

        }
    }

    /**
     * Register ServiceDesk as a singleton.
     *
     * @return void
     */
    protected function registerServiceDesk()
    {
        $this->app->singleton(ServiceDesk::class, function () {
            $token = null;
            if(session()->has('allcommerce-jwt-access-token'))
            {
                $token = session()->get('allcommerce-jwt-access-token');
            }
            return ServiceDesk::make($token)
                ->create();
        });
    }

    /**
     * Determine if we are running in the console.
     *
     * Copied from Laravel's Application class, since we need to support 6.x.
     *
     * @return bool
     */
    protected function runningInConsole()
    {
        return php_sapi_name() == 'cli' || php_sapi_name() == 'phpdbg';
    }
}

<?php

namespace CapeAndBay\AllCommerce;

use Illuminate\Support\ServiceProvider;

class ServiceDeskServiceProvider extends ServiceProvider
{
    const VERSION = '0.1.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadConfigs();
        $this->publishFiles();

        if ($this->runningInConsole()) {

        }
    }

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

    public function loadConfigs()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(__DIR__ . '/config/allcommerce-jwt.php', 'allcommerce-jwt');
    }

    public function publishFiles()
    {
        $capeandbay_config_files = [__DIR__ . '/config' => config_path()];

        $minimum = array_merge(
            $capeandbay_config_files
        );

        // register all possible publish commands and assign tags to each
        $this->publishes($capeandbay_config_files, 'config');
        $this->publishes($minimum, 'minimum');
    }
}

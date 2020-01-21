<?php

namespace CapeAndBay\AllCommerce\Facades;

use Illuminate\Support\Facades\Facade;
use CapeAndBay\AllCommerce\ServiceDesk as Reference;

class ServiceDesk extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Reference::class;
    }
}

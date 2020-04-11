<?php

namespace CapeAndBay\AllCommerce;

use CapeAndBay\AllCommerce\Auth\AccessToken;
use CapeAndBay\AllCommerce\Services\LibraryService;

class ServiceDeskFactory
{
    /**
     * The Access Token to use.
     *
     * @var mixed
     */
    protected $access_token;

    /**
     * Create a new TrapperKeeperFactory instance.
     *
     * @param mixed  $token
     */
    public function __construct($token = null)
    {
        $this->access_token = $token;
    }

    /**
     * Create an instance of TrapperKeeper.
     *
     * @return ServiceDesk
     */
    public function create()
    {
        $access_token = $this->getAccessToken();
        $keeper = new ServiceDesk($access_token, new LibraryService());

        return $keeper;
    }

    /**
     * Get an instance of the AccessToken.
     *
     * @return AccessToken
     */
    protected function getAccessToken()
    {
        return new AccessToken($this->access_token);
    }
}

<?php

namespace CapeAndBay\AllCommerce;

use Illuminate\Support\Facades\Log;
use CapeAndBay\AllCommerce\Auth\AccessToken;
use CapeAndBay\AllCommerce\ServiceDeskFactory;
use CapeAndBay\AllCommerce\Services\LibraryService;

class ServiceDesk
{
    protected $access_token, $library;

    public function __construct(AccessToken $access_token, LibraryService $lib)
    {
        $this->access_token = $access_token;
        $this->library = $lib;
    }

    /**
     * Create a new ServiceDesk instance.
     *
     * @param mixed $token
     * @return static
     */
    public static function create($token = null)
    {
        return static::make($token)->create();
    }

    /**
     * Create a ServiceDesk factory instance.
     *
     * @param  mixed  $token
     * @return ServiceDeskFactory
     */
    public static function make($token = null)
    {
        return new ServiceDeskFactory($token, new LibraryService());
    }

    /**
     * Login to the ServiceDesk service via JWT.
     *
     * @param  string  $username
     * @param  string  $password
     * @return ServiceDesk|bool
     */
    public function login($username, $password)
    {
        $results = false;
        /**
         * Steps
         * 1. Login with the AccessToken class.
         * 2. Get User Info with the FrontSleeve Object
         * 3. Get Account Info with the FrontSleeve Object
         */
        $login_response = $this->access_token->login($username, $password);

        if($login_response === true)
        {
            session()->put('allcommerce-jwt-access-token', $this->access_token->token());
            session()->put('allcommerce-username', $username);
            $results = $this;
        }
        else
        {
            if($login_response)
            {
                $results = $login_response;
            }
        }

        return $results;
    }

    public function get($feature = '')
    {
        $results = false;

        try
        {
            $asset = $this->library->retrieve($feature);

            if($asset)
            {
                $results = $asset;
            }
        }
        catch(\Exception $e)
        {
            Log::info('AllCommerce Feature - '.$feature.' not found.');
        }

        return $results;
    }

    public function getAccessToken()
    {
        return $this->access_token->token();
    }
}

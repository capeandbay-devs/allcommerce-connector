<?php

namespace CapeAndBay\AllCommerce\Auth;

use CapeAndBay\AllCommerce\Services\AllCommerceAPIClientService;

class AccessToken extends AllCommerceAPIClientService
{
    protected $api_access_token = null;
    protected $username;

    public function __construct($token = null)
    {
        parent::__construct();
        $this->api_access_token = $this->verifyAccessToken($token);
    }

    private function verifyAccessToken($token = null)
    {
        // @todo - Use the Api Service to call to validate the token unless null
        if(!is_null($token))
        {
            $headers = [
                "Authorization: Bearer $token"
            ];
            $response = $this->post($this->api_url().'/me', [], $headers);
        }

        return $token;

    }

    public function login($user, $pass)
    {
        $results = false;

        $payload = [
            'email' => $user,
            'password' => $pass
        ];

        $response = $this->post($this->api_url().'/login', $payload);

        if(is_array($response) && array_key_exists('error', $response))
        {
            $results = $response['error'];
        }
        else if(is_array($response) && array_key_exists('token', $response))
        {
            $results = true;
            $this->username = $user;
            $this->api_access_token = $response['token'];
        }

        return $results;
    }

    public function login_via_sso($platform, array $payload)
    {
        $results = false;

        $response = $this->post($this->api_url()."/{$platform}/sso", $payload);

        if(is_array($response) && array_key_exists('success', $response))
        {
            $results = $response['reason'];
        }
        elseif(is_array($response) && array_key_exists('error', $response))
        {
            $results = $response['error'];
        }
        else if(is_array($response) && array_key_exists('token', $response))
        {
            $results = true;
            $this->username = $response['user']['email'];
            $this->api_access_token = $response['token'];
        }

        return $results;
    }

    public function token()
    {
        return $this->api_access_token;
    }

    public function username()
    {
        return $this->username;
    }
}

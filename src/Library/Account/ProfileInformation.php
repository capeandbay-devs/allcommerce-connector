<?php

namespace CapeAndBay\AllCommerce\Library\Account;

use CapeAndBay\AllCommerce\Library\Feature;

class ProfileInformation extends Feature
{
    protected $url = '/me';
    protected $user_id, $user_name, $user_email;
    protected $user_account_created, $user_last_updated_timestamp;
    protected $user_roles;

    public function __construct()
    {
        parent::__construct();
        $profile = $this->getProfile();

        if(array_key_exists('token', $profile))
        {
            session()->put('allcommerce-jwt-access-token', $profile['token']);

            if(array_key_exists('user', $profile))
            {
                $this->user_id = $profile['user']['uuid'];
                $this->user_name = $profile['user']['name'];
                $this->user_email = $profile['user']['email'];
                $this->user_account_created = $profile['user']['created_at'];
                $this->user_last_updated_timestamp = $profile['user']['updated_at'];
                $this->user_roles = $profile['roles'];
            }
            else
            {
                $this->profile = false;
            }
        }
        else
        {
            $this->profile = false;
        }
    }

    public function my_url()
    {
        return $this->allcommerce_client->api_url().$this->url;
    }

    private function getProfile()
    {
        $results = [];

        try
        {
            $headers = [
                'Accept: vnd.allcommerce.v1+json',
                'Authorization: Bearer '.session()->get('allcommerce-jwt-access-token')
            ];
            $response = $this->allcommerce_client->post($this->my_url(), [], $headers);

            if($response)
            {
                $results = $response;
            }
        }
        catch(\Exception $e)
        {
            $results = $e->getMessage();
        }

        return $results;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function getUserEmail()
    {
        return $this->user_email;
    }

    public function getAccountCreatedDate()
    {
        return $this->user_account_created;
    }

    public function getAccountLastUpdated()
    {
        return $this->user_last_updated_timestamp;
    }

    public function getUserRoles()
    {
        return $this->user_roles;
    }
}

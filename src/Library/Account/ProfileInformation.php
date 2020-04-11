<?php

namespace CapeAndBay\AllCommerce\Library\Account;

use CapeAndBay\AllCommerce\Library\Feature;

class ProfileInformation extends Feature
{
    protected $url = '/me';
    protected $profile;

    public function __construct()
    {
        parent::__construct();
        $this->profile = $this->getProfile();
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
}

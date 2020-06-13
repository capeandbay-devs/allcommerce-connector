<?php

namespace CapeAndBay\AllCommerce\Library\Merchants;

use CapeAndBay\AllCommerce\Library\Feature;

class Merchant extends Feature
{
    protected $url = '/merchant';
    protected $access_token;
    protected $details;

    public function __construct($presets = [])
    {
        parent::__construct();
        $this->init();
    }

    public function merchant_url()
    {
        return $this->allcommerce_client->api_url().$this->url;
    }

    public function shopify_merchant_url()
    {
        return $this->allcommerce_client->api_url().'/shopify'.$this->url;
    }

    private function init()
    {
        if($results = $this->getMerchant())
        {
            $this->details = $results;
        }
        else
        {
            $this->details = null;
        }
    }

    public function getMerchant()
    {
        $results = false;

        try
        {
            if(!is_array($this->details))
            {
                $headers = [
                    'Accept: vnd.allcommerce.v1+json',
                    'Authorization: Bearer '.session()->get('allcommerce-jwt-access-token')
                ];
                $response = $this->allcommerce_client->get($this->merchant_url(), $headers);

                if($response)
                {
                    if(array_key_exists('success', $response) && $response['success'])
                    {
                        $results = $response['merchant'];
                    }
                }
            }
            else
            {
                $results = $this->details;
            }
        }
        catch(\Exception $e)
        {
            $results = $e->getMessage();
        }

        return $results;
    }

}

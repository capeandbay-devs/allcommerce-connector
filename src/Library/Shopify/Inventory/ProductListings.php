<?php

namespace CapeAndBay\AllCommerce\Library\Shopify\Inventory;

use CapeAndBay\AllCommerce\Library\Shopify\SalesChannel;

class ProductListings extends SalesChannel
{
    protected $inventory_url = '/inventory';

    public function __construct()
    {
        parent::__construct();
    }

    public function inventory_url()
    {
        return $this->ac_shopify_url().$this->inventory_url;
    }

    public function getAllProductListings($shop)
    {
        $results = false;

        $headers = [
            'Accept: vnd.allcommerce.v1+json',
            'Authorization: Bearer '.session()->get('allcommerce-jwt-access-token')
        ];

        $payload = [
            'shop' => $shop
        ];

        $response = $this->allcommerce_client->post($this->inventory_url(), $payload, $headers);

        if($response && array_key_exists('success', $response) && $response['success'])
        {
            $results = $response['listings'];
        }

        return $results;
    }

    public function getNewProductListings($shop)
    {
        $results = false;

        $headers = [
            'Accept: vnd.allcommerce.v1+json',
            'Authorization: Bearer '.session()->get('allcommerce-jwt-access-token')
        ];

        $payload = [
            'shop' => $shop
        ];

        $response = $this->allcommerce_client->post($this->inventory_url().'/new', $payload, $headers);

        if($response)
        {
            $results = $response;
        }

        return $results;
    }
}

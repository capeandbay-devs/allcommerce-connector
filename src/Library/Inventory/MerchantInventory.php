<?php

namespace CapeAndBay\AllCommerce\Library\Inventory;

use CapeAndBay\AllCommerce\Library\Feature;

class MerchantInventory extends Feature
{
    protected $url = '/inventory';
    protected $inventory, $merchant;

    public function __construct()
    {
        parent::__construct();

        $inventory = $this->getInventory();

        if(array_key_exists('inventory', $inventory))
        {
            $this->inventory = $inventory['inventory'];

            // @todo - this will need to be placed into an object via a function;
            $this->merchant = $inventory['merchant'];

            // @todo - do stuff after these messages.
        }
        else
        {
            $this->inventory = [];
        }
    }

    public function inventory_url()
    {
        return $this->allcommerce_client->api_url().$this->url;
    }

    private function getInventory()
    {
        $results = [];

        try
        {
            $headers = [
                'Accept: vnd.allcommerce.v1+json',
                'Authorization: Bearer '.session()->get('allcommerce-jwt-access-token')
            ];

            if(session()->has('active-merchant-uuid'))
            {
                $headers[] = 'merchant_uuid: '.session()->get('active-merchant-uuid');
            }

            $response = $this->allcommerce_client->get($this->inventory_url(), $headers);

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

    public function getItemsArray()
    {
        return $this->inventory;
    }

    public function getItemArray($query = [])
    {
        $results = [];

        $data = collect($this->inventory);

        if(!empty($query))
        {
            foreach ($query as $key => $item) {
                $results = $data->where($key, $item[0], $item[1]);
            }
        }

        return $results->toArray();
    }
}

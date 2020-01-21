<?php

namespace CapeAndBay\AllCommerce\Services;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Log;

class AllCommerceAPIClientService
{
    protected $root_url = 'http://ac-api.capeandbay.com';
    protected $api_url = '/api';

    public function __construct()
    {
        $this->root_url = env('ALLCOMMERCE_API_URL','http://ac-api.capeandbay.com');
    }

    public function api_url()
    {
        return $this->root_url.$this->api_url;
    }

    public function get($endpoint)
    {
        $results = false;

        $url = $endpoint;
        $response = Curl::to($url)
            ->withHeader('Accept: vnd.allcommerce.v1+json')
            ->asJson(true)
            ->get();

        if($response)
        {
            Log::info('LeadBinder Response from '.$url, $response);
            $results = $response;
        }
        else
        {
            Log::info('LeadBinder Null Response from '.$url);
        }

        return $results;
    }

    public function post($endpoint, $args = [], $headers = [])
    {
        $results = false;

        $url = $endpoint;

        if(!empty($args))
        {
            if(!empty($headers))
            {
                $response = Curl::to($url)
                    ->withHeaders($headers)
                    ->withData($args)
                    ->asJson(true)
                    ->post();
            }
            else
            {
                $response = Curl::to($url)
                    ->withHeader('Accept: vnd.allcommerce.v1+json')
                    ->withData($args)
                    ->asJson(true)
                    ->post();
            }
        }
        elseif(!empty($headers))
        {
            $response = Curl::to($url)
                ->withHeaders($headers)
                ->asJson(true)
                ->post();
        }
        else
        {
            $response = Curl::to($url)
                ->withHeader('Accept: vnd.allcommerce.v1+json')
                ->asJson(true)
                ->post();
        }

        if($response)
        {
            Log::info('AllCommerce Response from '.$url, $response);
            $results = $response;
        }
        else
        {
            Log::info('AllCommerce Null Response from '.$url);
        }

        return $results;
    }
}

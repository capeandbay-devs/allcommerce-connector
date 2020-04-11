<?php

namespace CapeAndBay\AllCommerce\Services;

class LibraryService
{
    public function __construct()
    {

    }

    public function retrieve($feature = '')
    {
        $results = false;

        switch($feature)
        {
            default:
                $results = $this->basicLoadObj($feature);
        }

        return $results;
    }

    public function basicLoadObj($name)
    {
        try
        {
            $port_model_name = config('allcommerce-jwt.class_maps.'.$name);

            $results = new $port_model_name();
        }
        catch(\Exception $e)
        {
            $results = true;
        }

        return new $results;
    }
}

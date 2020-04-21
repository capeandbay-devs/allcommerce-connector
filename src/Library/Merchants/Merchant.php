<?php

namespace CapeAndBay\AllCommerce\Library\Merchants;

use CapeAndBay\AllCommerce\Library\Feature;

class Merchant extends Feature
{
    protected $url = '/merchants';

    public function __construct($presets = [])
    {
        parent::__construct();
    }
}

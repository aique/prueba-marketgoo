<?php

namespace MarketgooApp\Region\Strategy\WebService;

use MarketgooApp\Model\Region\Region;

interface WebServiceRequester
{
    /** @return Region */
    function request($ip);
}
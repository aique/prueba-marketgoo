<?php

namespace MarketgooApp\Region\Strategy\WebService;

use MarketgooApp\Model\Region\Region;

interface Requester
{
    /** @return Region */
    function request($ip);
}
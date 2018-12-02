<?php

namespace MarketgooApp\Region\WebService\Resource;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\WebService\Requester;

class DbIpRequester implements Requester
{
    function request($ip) {
        return new Region('Matalascañas', 'Huelva', 'Spain');
    }

}
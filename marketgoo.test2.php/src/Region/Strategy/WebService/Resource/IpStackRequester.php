<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\Strategy\WebService\Requester;

class IpStackRequester implements Requester
{
    function request($ip) {
        return new Region('Matalascañas', 'Huelva', 'Spain');
    }

}
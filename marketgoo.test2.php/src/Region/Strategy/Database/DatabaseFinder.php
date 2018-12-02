<?php

namespace MarketgooApp\Region\Strategy\Database;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\RegionFinder;

class DatabaseFinder implements RegionFinder
{
    public function getRegion($ip) {
        return new Region('Cleveland', 'Ohio', 'US');
    }
}
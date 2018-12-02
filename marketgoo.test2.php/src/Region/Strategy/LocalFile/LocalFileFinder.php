<?php

namespace MarketgooApp\Region\Strategy\LocalFile;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\RegionFinder;

class LocalFileFinder implements RegionFinder
{
    public function getRegion($ip) {
        return new Region('Santiago', 'Metropolitana', 'CL');
    }
}
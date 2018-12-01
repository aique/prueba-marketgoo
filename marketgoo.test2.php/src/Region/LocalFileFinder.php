<?php

namespace MarketgooApp\Region;

class LocalFileFinder implements RegionFinder
{
    public function getRegion($ip) {
        return 'Mieres';
    }
}
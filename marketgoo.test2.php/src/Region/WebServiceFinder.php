<?php

namespace MarketgooApp\Region;

class WebServiceFinder implements RegionFinder
{
    public function getRegion($ip) {
        return 'Matalascañas';
    }
}
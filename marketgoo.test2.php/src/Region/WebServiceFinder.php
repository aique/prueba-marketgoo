<?php

namespace MarketgooTest\Region;

class WebServiceFinder implements RegionFinder
{
    public function getRegion($ip) {
        return 'Matalascañas';
    }
}
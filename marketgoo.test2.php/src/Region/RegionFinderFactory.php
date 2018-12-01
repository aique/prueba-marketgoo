<?php

namespace MarketgooTest\Region;

class RegionFinderFactory
{
    public function create($strategy) {
        return new WebServiceFinder();
    }
}
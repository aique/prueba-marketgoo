<?php

namespace MarketgooTest\Region;

interface RegionFinder
{
    function getRegion($ip);
}
<?php

namespace MarketgooApp\Region;

interface RegionFinder
{
    function getRegion($ip);
}
<?php

namespace MarketgooApp\Region\Strategy;

abstract class RegionFinderStrategy
{
    const WEB_SERVICE_STRATEGY = "web_service";
    const LOCAL_FILE_STRATEGY = "local_file";
    const DATABAS_STRATEGY = "database";
}
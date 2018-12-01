<?php

namespace MarketgooApp\Region;

class RegionFinderFactory
{
    const WEB_SERVICE_STRATEGY = "web_service";
    const LOCAL_FILE_STRATEGY = "local_file";

    private $strategy;

    public function __construct($strategy) {
        $this->strategy = $strategy;
    }

    public function create() {
        switch ($this->strategy) {
            case self::WEB_SERVICE_STRATEGY:
                return new WebServiceFinder();
            case self::LOCAL_FILE_STRATEGY;
                return new LocalFileFinder();
            default:
                return new LocalFileFinder();
        }
    }
}
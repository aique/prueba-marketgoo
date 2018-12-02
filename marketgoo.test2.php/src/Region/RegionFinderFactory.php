<?php

namespace MarketgooApp\Region;

use MarketgooApp\Region\Strategy\Database\DatabaseFinder;
use MarketgooApp\Region\Strategy\DatabaseStrategy;
use MarketgooApp\Region\Strategy\LocalFile\LocalFileFinder;
use MarketgooApp\Region\Strategy\LocalFileStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Region\Strategy\WebService\WebServiceFinder;
use MarketgooApp\Region\Strategy\WebServiceStrategy;

class RegionFinderFactory
{
    /** @var RegionFinderStrategy  */
    private $strategy;

    public function __construct(RegionFinderStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function create() {

        switch (get_class($this->strategy)) {
            case WebServiceStrategy::class:
                return $this->createWebServiceFinder();
            case LocalFileStrategy::class;
                return new LocalFileFinder();
            case DatabaseStrategy::class;
                return new DatabaseFinder();
            default:
                return $this->createWebServiceFinder();
        }
    }

    private function createWebServiceFinder() {
        $resource = $this->strategy->getResource();
        return new WebServiceFinder(new RequesterFactory($resource));
    }
}
<?php

namespace MarketgooTest\Region;

use MarketgooApp\Region\RegionFinderFactory;
use MarketgooApp\Region\Strategy\Database\DatabaseFinder;
use MarketgooApp\Region\Strategy\DatabaseStrategy;
use MarketgooApp\Region\Strategy\LocalFile\LocalFileFinder;
use MarketgooApp\Region\Strategy\LocalFileStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\WebService\WebServiceFinder;
use MarketgooApp\Region\Strategy\WebServiceStrategy;
use PHPUnit\Framework\TestCase;

class RegionFinderFactoryTest extends TestCase
{
    public function testCreate() {
        $this->assertStrategy(new WebServiceStrategy(null), WebServiceFinder::class);
        $this->assertStrategy(new LocalFileStrategy(), LocalFileFinder::class);
        $this->assertStrategy(new DatabaseStrategy(), DatabaseFinder::class);
    }

    private function assertStrategy(RegionFinderStrategy $strategy, $instanceOfExpected) {
        $factory = new RegionFinderFactory($strategy);
        $this->assertInstanceOf($instanceOfExpected, $factory->create());
    }
}

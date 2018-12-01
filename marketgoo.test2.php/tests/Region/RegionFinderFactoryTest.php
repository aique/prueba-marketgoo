<?php

namespace MarketgooTest\Region;

use MarketgooApp\Region\LocalFileFinder;
use MarketgooApp\Region\RegionFinderFactory;
use MarketgooApp\Region\WebServiceFinder;
use PHPUnit\Framework\TestCase;

class RegionFinderFactoryTest extends TestCase
{
    public function testCreate() {
        $this->assertStrategy(RegionFinderFactory::WEB_SERVICE_STRATEGY, WebServiceFinder::class);
        $this->assertStrategy(RegionFinderFactory::LOCAL_FILE_STRATEGY, LocalFileFinder::class);
        $this->assertStrategy('wrong_strategy', LocalFileFinder::class);
    }

    private function assertStrategy($strategy, $instanceOfExpected) {
        $factory = new RegionFinderFactory($strategy);
        $this->assertInstanceOf($instanceOfExpected, $factory->create());
    }
}

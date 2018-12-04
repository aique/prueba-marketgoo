<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\LocalFileStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;

class LocalFileStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new LocalFileStrategy();
    }

    protected function setUpStrategyFactory() {
        $this->strategyFactory = new StrategyFactory(RegionFinderStrategy::LOCAL_FILE_STRATEGY);
    }
}
<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\DatabaseStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;

class DatabaseStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new DatabaseStrategy();
    }

    protected function setUpStrategyFactory() {
        $this->strategyFactory = new StrategyFactory(RegionFinderStrategy::DATABASE_STRATEGY);
    }
}
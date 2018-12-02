<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\DatabaseStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;
use Psr\Http\Message\ServerRequestInterface;

class DatabaseStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new DatabaseStrategy();
    }

    protected function setUpStrategyFactory() {
        $request = \Mockery::mock(ServerRequestInterface::class);

        $request->shouldReceive('getQueryParams')->andReturn([
            StrategyFactory::STRATEGY_PARAM => RegionFinderStrategy::DATABAS_STRATEGY
        ]);

        $this->strategyFactory = new StrategyFactory($request);
    }
}
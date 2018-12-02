<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\LocalFileStrategy;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;
use Psr\Http\Message\ServerRequestInterface;

class LocalFileStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new LocalFileStrategy();
    }

    protected function setUpStrategyFactory() {
        $request = \Mockery::mock(ServerRequestInterface::class);

        $request->shouldReceive('getQueryParams')->andReturn([
            StrategyFactory::STRATEGY_PARAM => RegionFinderStrategy::LOCAL_FILE_STRATEGY
        ]);

        $this->strategyFactory = new StrategyFactory($request);
    }
}
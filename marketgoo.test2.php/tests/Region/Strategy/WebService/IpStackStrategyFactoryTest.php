<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Region\Strategy\WebServiceStrategy;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;
use Psr\Http\Message\ServerRequestInterface;

class DbIpStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new WebServiceStrategy(RequesterFactory::IP_STACK_REQUESTER);
    }

    protected function setUpStrategyFactory() {
        $request = \Mockery::mock(ServerRequestInterface::class);

        $request->shouldReceive('getQueryParams')->andReturn([
            StrategyFactory::STRATEGY_PARAM => RegionFinderStrategy::WEB_SERVICE_STRATEGY,
            WebServiceStrategy::WEB_SERVICE_RESOURCE => RequesterFactory::IP_STACK_REQUESTER
        ]);

        $this->strategyFactory = new StrategyFactory($request);
    }
}
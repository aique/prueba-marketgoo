<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Region\Strategy\StrategyFactory;
use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Region\Strategy\WebServiceStrategy;
use MarketgooTest\Region\Strategy\StrategyFactoryTest;

class IpStackStrategyFactoryTest extends StrategyFactoryTest
{
    protected function setUpExpectedStrategy() {
        $this->strategy = new WebServiceStrategy(RequesterFactory::DB_IP_REQUESTER);
    }

    protected function setUpStrategyFactory() {
        // TODO pasar el resource RequesterFactory::DB_IP_REQUESTER
        $this->strategyFactory = new StrategyFactory(RegionFinderStrategy::WEB_SERVICE_STRATEGY);
    }
}
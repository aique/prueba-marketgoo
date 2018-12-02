<?php

namespace MarketgooApp\Region\Strategy\WebService;

use MarketgooApp\Region\RegionFinder;

class WebServiceFinder implements RegionFinder
{
    /** @var RequesterFactory */
    private $requesterFactory;

    public function __construct(RequesterFactory $requesterFactory) {
        $this->requesterFactory = $requesterFactory;
    }

    public function getRegion($ip) {
        $region = $this->requesterFactory->create()->request($ip);
        return $region->__toString();
    }
}
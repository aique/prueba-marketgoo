<?php

namespace MarketgooApp\Region\Strategy;

use MarketgooApp\Region\Strategy\WebService\RequesterFactory;

class WebServiceStrategy extends RegionFinderStrategy
{
    const WEB_SERVICE_RESOURCE = 'resource';

    private $resource;

    public function __construct($resource = RequesterFactory::DEFAULT_REQUESTER) {
        $this->resource = $resource;
    }

    public function getResource() {
        return $this->resource;
    }
}
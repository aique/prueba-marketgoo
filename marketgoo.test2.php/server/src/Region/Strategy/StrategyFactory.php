<?php

namespace MarketgooApp\Region\Strategy;

use MarketgooApp\Region\Strategy\WebService\RequesterFactory;

class StrategyFactory
{
    private $strategy;

    public function __construct($strategy = RegionFinderStrategy::WEB_SERVICE_STRATEGY) {
        $this->strategy = $strategy;
    }

    public function create() {
        switch ($this->strategy) {
            case RegionFinderStrategy::WEB_SERVICE_STRATEGY:
                return $this->createWebServiceStrategy();
            case RegionFinderStrategy::LOCAL_FILE_STRATEGY:
                return new LocalFileStrategy();
            case RegionFinderStrategy::DATABASE_STRATEGY:
                return new DatabaseStrategy();
            default:
                return $this->createWebServiceStrategy();
        }
    }

    private function createWebServiceStrategy($resource = null) { // TODO pasar el argumento correctamente
        $requestFactory = new RequesterFactory();

        if ($requestFactory->invalidResource($resource)) {
            $resource = RequesterFactory::DEFAULT_REQUESTER;
        }

        return new WebServiceStrategy($resource);
    }
}
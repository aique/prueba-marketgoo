<?php

namespace MarketgooApp\Region\Strategy;

use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Request\RequestQueryParameter;
use Psr\Http\Message\ServerRequestInterface;

class StrategyFactory
{
    const STRATEGY_PARAM = 'strategy';

    private $request;
    private $requestQueryParameter;

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
        $this->requestQueryParameter = new RequestQueryParameter($this->request);
    }

    public function create() {
        $strategy = $this->requestQueryParameter->getQueryParam('strategy');

        switch ($strategy) {
            case RegionFinderStrategy::WEB_SERVICE_STRATEGY:
                return $this->createWebServiceStrategy();
            case RegionFinderStrategy::LOCAL_FILE_STRATEGY:
                return new LocalFileStrategy();
            case RegionFinderStrategy::DATABAS_STRATEGY:
                return new DatabaseStrategy();
            default:
                return $this->createWebServiceStrategy();
        }
    }

    private function createWebServiceStrategy() {
        $resource = $this->requestQueryParameter->getQueryParam('resource');

        $requestFactory = new RequesterFactory();

        if ($requestFactory->invalidResource($resource)) {
            $resource = RequesterFactory::DEFAULT_REQUESTER;
        }

        return new WebServiceStrategy($resource);
    }
}
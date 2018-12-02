<?php

namespace MarketgooTest\Request;

use MarketgooApp\Region\RegionFinderFactory;
use MarketgooApp\Region\Strategy\RegionFinderStrategy;
use MarketgooApp\Request\RequestQueryParameter;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RequestQueryParameterTest extends TestCase
{
    /** @var RequestQueryParameter */
    private $requestQueryParameter;

    public function testGetQueryParam() {
        $this->setUpQueryParameter([]);

        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy'), null);
        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy', RegionFinderStrategy::WEB_SERVICE_STRATEGY), RegionFinderStrategy::WEB_SERVICE_STRATEGY);
    }

    public function testDefaultGetQueryParam() {
        $this->setUpQueryParameter(['strategy' => RegionFinderStrategy::LOCAL_FILE_STRATEGY]);

        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy'), RegionFinderStrategy::LOCAL_FILE_STRATEGY);
        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy', RegionFinderStrategy::WEB_SERVICE_STRATEGY), RegionFinderStrategy::LOCAL_FILE_STRATEGY);
    }

    private function setUpQueryParameter(array $requestQueryParams) {
        $request = \Mockery::mock(ServerRequestInterface::class);
        $request->shouldReceive('getQueryParams')->andReturn($requestQueryParams);
        $this->requestQueryParameter = new RequestQueryParameter($request);
    }
}

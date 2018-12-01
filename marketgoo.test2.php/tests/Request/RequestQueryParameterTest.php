<?php

namespace MarketgooTest\Request;

use MarketgooApp\Region\RegionFinderFactory;
use PHPUnit\Framework\TestCase;
use MarketgooApp\Request\RequestQueryParameter;
use Psr\Http\Message\ServerRequestInterface;

class RequestQueryParameterTest extends TestCase
{
    /** @var RequestQueryParameter */
    private $requestQueryParameter;

    public function testGetQueryParam() {
        $this->setUpQueryParameter([]);

        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy'), null);
        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy', RegionFinderFactory::WEB_SERVICE_STRATEGY), RegionFinderFactory::WEB_SERVICE_STRATEGY);
    }

    public function testDefaultGetQueryParam() {
        $this->setUpQueryParameter(['strategy' => RegionFinderFactory::LOCAL_FILE_STRATEGY]);

        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy'), RegionFinderFactory::LOCAL_FILE_STRATEGY);
        $this->assertEquals($this->requestQueryParameter->getQueryParam('strategy', RegionFinderFactory::WEB_SERVICE_STRATEGY), RegionFinderFactory::LOCAL_FILE_STRATEGY);
    }

    private function setUpQueryParameter(array $requestQueryParams) {
        $request = \Mockery::mock(ServerRequestInterface::class);
        $request->shouldReceive('getQueryParams')->andReturn($requestQueryParams);
        $this->requestQueryParameter = new RequestQueryParameter($request);
    }
}

<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Region\Strategy\WebService\WebServiceFinder;
use MarketgooApp\Region\Strategy\WebService\WebServiceRequester;
use PHPUnit\Framework\TestCase;

class WebServiceFinderTest extends TestCase
{
    /** @var WebServiceFinder */
    private $webServiceFinder;
    private $region;

    protected function setUp() {
        $this->region = new Region(
            'Peterborough',
            'England',
            'GB'
        );

        $requester = \Mockery::mock(WebServiceRequester::class);
        $requester->shouldReceive('request')->andReturn($this->region);

        $requesterFactory = \Mockery::mock(RequesterFactory::class);
        $requesterFactory->shouldReceive('create')->andReturn($requester);
        
        $this->webServiceFinder = new WebServiceFinder($requesterFactory);
    }

    public function testGetRegion() {
        $this->assertEquals($this->region, $this->webServiceFinder->getRegion(''));
    }
}

<?php

namespace MarketgooTest\Region\Strategy\WebService;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use MarketgooApp\Region\Strategy\WebService\WebServiceFinder;
use PHPUnit\Framework\TestCase;

class WebServiceFinderTest extends TestCase
{
    const IP = '188.223.227.125';

    /** @var WebServiceFinder */
    private $webServiceFinder;
    private $region;

    protected function setUp() {
        $this->webServiceFinder = new WebServiceFinder(new RequesterFactory());

        $this->region = new Region(
            'Peterborough',
            'England',
            'GB'
        );
    }

    public function testGetRegion() {
        $this->assertEquals($this->region, $this->webServiceFinder->getRegion(self::IP)); // TODO no realizar la llamada al servicio, hacer mock
    }
}

<?php

namespace MarketgooTest\Region;

use MarketgooApp\Region\WebServiceFinder;
use PHPUnit\Framework\TestCase;

class WebServiceFinderTest extends TestCase
{
    /** @var WebServiceFinder */
    private $webServiceFinder;

    protected function setUp() {
        $this->webServiceFinder = new WebServiceFinder();
    }

    public function testGetRegion() {
        $this->assertEquals('Matalascañas', $this->webServiceFinder->getRegion(''));
    }
}

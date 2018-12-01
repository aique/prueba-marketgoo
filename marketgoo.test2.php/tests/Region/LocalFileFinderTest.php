<?php

namespace MarketgooTest\Region;

use MarketgooApp\Region\LocalFileFinder;
use PHPUnit\Framework\TestCase;

class LocalFileFinderTest extends TestCase
{
    /** @var LocalFileFinder */
    private $localFileFinder;

    protected function setUp() {
        $this->localFileFinder = new LocalFileFinder();
    }

    public function testGetRegion() {
        $this->assertEquals('Mieres', $this->localFileFinder->getRegion(''));
    }
}

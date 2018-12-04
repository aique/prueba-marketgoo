<?php

namespace MarketgooTest\Region\Strategy\LocaleFile;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\Strategy\LocalFile\LocalFileFinder;
use PHPUnit\Framework\TestCase;

class LocalFileFinderTest extends TestCase
{
    /** @var LocalFileFinder */
    private $localFileFinder;
    private $region;

    protected function setUp() {
        $this->localFileFinder = new LocalFileFinder();

        $this->region = new Region(
            'Santiago',
            'Metropolitana',
            'CL'
        );
    }

    public function testGetRegion() {
        $this->assertEquals($this->region, $this->localFileFinder->getRegion(''));
    }
}

<?php

namespace MarketgooTest\Region\Srategy\Database;

use MarketgooApp\Model\Region\Region;
use MarketgooApp\Region\Strategy\Database\DatabaseFinder;
use PHPUnit\Framework\TestCase;

class DatabaseFinderTest extends TestCase
{
    /** @var DatabaseFinder */
    private $databaseFinder;
    private $region;

    protected function setUp() {
        $this->databaseFinder = new DatabaseFinder();

        $this->region = new Region(
            'Cleveland',
            'Ohio',
            'US'
        );
    }

    public function testGetRegion() {
        $this->assertEquals($this->region, $this->databaseFinder->getRegion(''));
    }
}

<?php

namespace MarketgooTest\Region\Strategy;

use MarketgooApp\Region\Strategy\WebService\RequesterFactory;
use PHPUnit\Framework\TestCase;

class RequesterFactoryTest extends TestCase
{
    /** @var RequesterFactory */
    private $requesterFactory;

    protected function setUp() {
        $this->requesterFactory = new RequesterFactory();
    }

    public function testInvalidResource() {

    }

    public function testCreate() {

    }
}

<?php

namespace MarketgooTest\Region\Strategy\WebService;

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
        $this->assertFalse($this->requesterFactory->invalidResource(RequesterFactory::IP_STACK_REQUESTER));
        $this->assertFalse($this->requesterFactory->invalidResource(RequesterFactory::DB_IP_REQUESTER));
        $this->assertTrue($this->requesterFactory->invalidResource('otro'));
        $this->assertTrue($this->requesterFactory->invalidResource(''));
        $this->assertTrue($this->requesterFactory->invalidResource(123));
        $this->assertTrue($this->requesterFactory->invalidResource(null));
    }
}
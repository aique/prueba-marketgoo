<?php

namespace MarketgooTest\Model\Aggregation;

use MarketgooApp\Model\Aggregation\IpRegionAggregator;
use MarketgooApp\Region\RegionFinder;
use MarketgooApp\Region\RegionFinderFactory;
use PHPUnit\Framework\TestCase;

class IpRegionAggregatorTest extends TestCase
{
    const REGION_VALUE = 'Matalascañas';

    /** @var IpRegionAggregator */
    private $ipRegionAggregator;

    protected function setUp() {
        $regionFinder = \Mockery::mock(RegionFinder::class);
        $regionFinder->shouldReceive('getRegion')->andReturn(self::REGION_VALUE);

        $factory = \Mockery::mock(RegionFinderFactory::class);
        $factory->shouldReceive('create')->andReturn($regionFinder);
        $this->ipRegionAggregator = new IpRegionAggregator($factory);
    }

    public function testAggregate() {
        $user = ["id" => 1, "name" => "Sergio Palma", "ip" => "188.223.227.125"];
        $user = $this->ipRegionAggregator->aggregate($user);
        $this->assertArrayHasKey(IpRegionAggregator::IP_REGION_FIELD_NAME, $user);
        $this->assertEquals(self::REGION_VALUE, $user[IpRegionAggregator::IP_REGION_FIELD_NAME]);
    }
}

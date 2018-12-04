<?php

namespace MarketgooTest\Model;

use MarketgooApp\Model\User\Aggregation\IpRegionAggregator;
use MarketgooApp\Model\User\AggregatorSolver;
use PHPUnit\Framework\TestCase;

class AggregatorSolverTest extends TestCase
{
    /** @var AggregatorSolver */
    private $aggregatorSolver;
    private $entities;
    private $ipRegionAggregatedEntities;

    protected function setUp()
    {
        $this->entities = [
            [
                "id" => 1,
                "name" => "Sergio Palma",
                "ip" => "188.223.227.125",
            ],
            [
                "id" => 2,
                "name" => "Manolo Engracia",
                "ip" => "194.191.232.168",
            ]
        ];

        $this->entities = [
            $this->getEntity(1),
            $this->getEntity(2),
        ];

        $this->ipRegionAggregatedEntities = [
            $this->getEntity(1, true),
            $this->getEntity(2, true),
        ];
    }

    public function testGetEntitySingleAggregator() {
        $aggregator = $this->createEntityAggregator();
        $this->aggregatorSolver = new AggregatorSolver([$aggregator]);

        $this->assertEquals($this->ipRegionAggregatedEntities[0], $this->aggregatorSolver->getEntity($this->entities[0]));
    }

    public function testGetEntityMultipleAggregators() {

        $aggregator1 = $this->createEntityAggregator();
        $aggregator2 = $this->createEntityAggregator();
        $this->aggregatorSolver = new AggregatorSolver([$aggregator1, $aggregator2]);

        $this->assertEquals($this->ipRegionAggregatedEntities[0], $this->aggregatorSolver->getEntity($this->entities[0]));
    }

    private function createEntityAggregator() {
        $aggregator = \Mockery::mock(IpRegionAggregator::class);
        $aggregator->shouldReceive('aggregate')->andReturn($this->ipRegionAggregatedEntities[0]);
        $aggregator->shouldReceive('isUpdated')->andReturn(true);

        return $aggregator;
    }

    public function testGetCollectionSingleAggregator() {
        $aggregator1 = $this->createCollectionAggregator();
        $aggregator2 = $this->createCollectionAggregator();

        $this->aggregatorSolver = new AggregatorSolver([$aggregator1, $aggregator2]);

        $this->assertEquals($this->ipRegionAggregatedEntities, $this->aggregatorSolver->getCollection($this->entities));
    }

    private function createCollectionAggregator() {
        $aggregator = \Mockery::mock(IpRegionAggregator::class);

        $aggregator
            ->shouldReceive('aggregate')
            ->with($this->entities[0])
            ->andReturn($this->ipRegionAggregatedEntities[0]);

        $aggregator
            ->shouldReceive('aggregate')
            ->with($this->ipRegionAggregatedEntities[0])
            ->andReturn($this->ipRegionAggregatedEntities[0]);

        $aggregator
            ->shouldReceive('aggregate')
            ->with($this->entities[1])
            ->andReturn($this->ipRegionAggregatedEntities[1]);

        $aggregator
            ->shouldReceive('aggregate')
            ->with($this->ipRegionAggregatedEntities[1])
            ->andReturn($this->ipRegionAggregatedEntities[1]);

        $aggregator->shouldReceive('isUpdated')->andReturn(true);

        return $aggregator;
    }

    private function getEntity($id, $addIpRegion = false) {
        $entityFound = null;

        foreach ($this->entities as $entity) {
            if ($entity["id"] == $id) {
                $entityFound = $entity;
                break;
            }
        }

        if ($entityFound && $addIpRegion) {
            $entityFound[IpRegionAggregator::IP_REGION_FIELD_NAME] = "Matalascañas, Huelva - ES";
        }

        return $entityFound;
    }
}

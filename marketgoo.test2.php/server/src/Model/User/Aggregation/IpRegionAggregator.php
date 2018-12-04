<?php

namespace MarketgooApp\Model\User\Aggregation;

use MarketgooApp\Region\RegionFinderFactory;

class IpRegionAggregator extends Aggregator
{
    const IP_FIELD_NAME = 'ip';
    const IP_REGION_FIELD_NAME = 'ip_region';

    /** @var RegionFinderFactory */
    private $regionFinderFactory;

    public function __construct(RegionFinderFactory $regionFinderFactory) {
        parent::__construct();

        $this->regionFinderFactory = $regionFinderFactory;
    }

    protected function getAttributeName() {
        return self::IP_REGION_FIELD_NAME;
    }

    protected function aggregateAttribute($entity) {
        if ($this->hasAttribute($entity, self::IP_FIELD_NAME)) {
            $entity[self::IP_REGION_FIELD_NAME] = $this->getRegion($entity);
            $this->updated = true;
        }

        return $entity;
    }

    private function getRegion($entity) {
        $regionFinder = $this->regionFinderFactory->create();
        $ip = $entity[self::IP_FIELD_NAME];

        return $regionFinder->getRegion($ip);
    }
}
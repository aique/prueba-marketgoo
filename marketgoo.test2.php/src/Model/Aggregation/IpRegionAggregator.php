<?php

namespace MarketgooApp\Model\Aggregation;

use MarketgooApp\Region\RegionFinderFactory;

class IpRegionAggregator implements Aggregator
{
    const IP_FIELD_NAME = 'ip';
    const IP_REGION_FIELD_NAME = 'ip_region';

    /** @var RegionFinderFactory */
    private $regionFinderFactory;

    public function __construct(RegionFinderFactory $regionFinderFactory) {
        $this->regionFinderFactory = $regionFinderFactory;
    }

    public function aggregate($user) {
        if ($this->hasRegionIp($user)) {
            return $user;
        }

        $user = $this->setIpRegion($user);
        $this->updateUserInDb($user);

        return $user;
    }

    private function hasRegionIp($user) {
        return isset($user[self::IP_REGION_FIELD_NAME]);
    }

    private function hasIp($user) {
        return isset($user[self::IP_FIELD_NAME]);
    }

    private function setIpRegion($user) {
        if ($this->hasIp($user)) {
            $regionFinder = $this->regionFinderFactory->create();
            $user[self::IP_REGION_FIELD_NAME] = $regionFinder->getRegion($user[self::IP_FIELD_NAME]);
        }

        return $user;
    }

    private function updateUserInDb() {
        // TODO en caso de obtener la respuesta de base de datos, se debería guardar la región del usuario en este punto
    }
}
<?php

namespace MarketgooApp\Model\User;

class AggregatorSolver
{
    private $aggregators;

    public function __construct(array $aggregators) {
        $this->aggregators = $aggregators;
    }

    public function getEntity($entity) {
        $entity = $this->applyAggregators($entity);

        return $entity;
    }

    public function getCollection($collection) {
        foreach ($collection as $userKey => $userData) {
            $collection[$userKey] = $this->applyAggregators($userData);
        }

        return $collection;
    }

    private function applyAggregators($entity) {
        foreach ($this->aggregators as $agreggator) {
            $entity = $agreggator->aggregate($entity);

            if ($agreggator->isUpdated()) {
                $this->updateEntityInDb();
            }
        }

        return $entity;
    }

    private function updateEntityInDb() {} // TODO funcionalidad pendiente de implementar
}
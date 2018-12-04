<?php

namespace MarketgooApp\Model\User\Aggregation;

abstract class Aggregator
{
    protected $updated;

    public function __construct() {
        $this->updated = false;
    }

    public function aggregate($entity) {
        if ($this->hasAttribute($entity, $this->getAttributeName())) {
            return $entity;
        }

        return $this->aggregateAttribute($entity);
    }

    public function isUpdated() {
        return $this->updated;
    }

    protected function hasAttribute($entity, $name) {
        return isset($entity[$name]);
    }

    protected abstract function getAttributeName();
    protected abstract function aggregateAttribute($entity);
}
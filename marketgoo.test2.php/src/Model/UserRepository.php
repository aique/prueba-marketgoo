<?php

namespace MarketgooTest\Model;

class UserRepository
{
    private $aggregators;

    public function __construct(array $aggregators) {
        $this->aggregators = $aggregators;
    }

    public function getUser($user) {
        $user = $this->applyAggregators($user);

        return $user;
    }

    public function getCollection($users) {
        foreach ($users as &$user) {
            $this->applyAggregators($user);
        }

        return $users;
    }

    private function applyAggregators($user) {
        foreach ($this->aggregators as $agreggator) {
            $user = $agreggator->aggregate($user);
        }

        return $user;
    }
}
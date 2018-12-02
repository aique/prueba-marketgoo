<?php

namespace MarketgooApp\Model\User;

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
        foreach ($users as $userKey => $userData) {
            $users[$userKey] = $this->applyAggregators($userData);
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
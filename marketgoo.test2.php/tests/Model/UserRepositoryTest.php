<?php

namespace MarketgooTest\Model;

use MarketgooApp\Model\User\Aggregation\IpRegionAggregator;
use MarketgooApp\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    /** @var UserRepository */
    private $userRepository;
    private $users;
    private $ipRegionAggregatedUsers;

    protected function setUp()
    {
        $this->users = [
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

        $this->users = [
            $this->getUser(1),
            $this->getUser(2),
        ];

        $this->ipRegionAggregatedUsers = [
            $this->getUser(1, true),
            $this->getUser(2, true),
        ];
    }

    public function testGetUser() {
        $aggregatorResponse = $this->ipRegionAggregatedUsers[0];

        $ipRegionAggregator = \Mockery::mock(IpRegionAggregator::class);
        $ipRegionAggregator->shouldReceive('aggregate')->andReturn($aggregatorResponse);
        $this->userRepository = new UserRepository([$ipRegionAggregator]);

        $this->assertEquals($aggregatorResponse, $this->userRepository->getUser($this->users[0]));
    }

    public function testGetCollection() {
        $ipRegionAggregator = \Mockery::mock(IpRegionAggregator::class);

        $ipRegionAggregator
            ->shouldReceive('aggregate')
            ->with($this->users[0])
            ->andReturn($this->ipRegionAggregatedUsers[0]);

        $ipRegionAggregator
            ->shouldReceive('aggregate')
            ->with($this->users[1])
            ->andReturn($this->ipRegionAggregatedUsers[1]);

        $this->userRepository = new UserRepository([$ipRegionAggregator]);

        $this->assertEquals($this->ipRegionAggregatedUsers, $this->userRepository->getCollection($this->users));
    }

    private function getUser($userId, $addIpRegion = false) {
        $userFound = null;

        foreach ($this->users as $user) {
            if ($user["id"] == $userId) {
                $userFound = $user;
                break;
            }
        }

        if ($userFound && $addIpRegion) {
            $userFound[IpRegionAggregator::IP_REGION_FIELD_NAME] = "Matalascañas, Huelva - ES";
        }

        return $userFound;
    }
}

<?php

namespace MarketgooApp\Model\Region;

class Region
{
    private $city;
    private $region;
    private $country;

    public function __construct($city, $region, $country) {
        $this->city = $city;
        $this->region = $region;
        $this->country = $country;
    }

    public function __toString() {
        return $this->city.', '.$this->region.' - '.$this->country;
    }
}
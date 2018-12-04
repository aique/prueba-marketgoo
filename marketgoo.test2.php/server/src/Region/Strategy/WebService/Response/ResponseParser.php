<?php

namespace MarketgooApp\Region\Strategy\WebService\Response;

use GuzzleHttp\Psr7\Response;
use MarketgooApp\Model\Region\Region;

abstract class ResponseParser
{
    public function parse(Response $response) {
        $body = json_decode($response->getBody(), true);

        $city = $this->getValue($body, $this->getCityFieldName());
        $region = $this->getValue($body, $this->getRegionFieldName());
        $country = $this->getValue($body, $this->getCountryCodeFieldName());

        return new Region($city, $region, $country);
    }

    private function getValue($values, $name) {
        $value = null;

        if (isset($values[$name])) {
            $value = $values[$name];
        }

        return $value;
    }

    protected abstract function getCityFieldName();
    protected abstract function getRegionFieldName();
    protected abstract function getCountryCodeFieldName();
}
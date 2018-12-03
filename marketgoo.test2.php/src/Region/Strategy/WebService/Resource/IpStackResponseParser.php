<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use GuzzleHttp\Psr7\Response;
use MarketgooApp\Model\Region\Region;

class IpStackResponseParser implements ResponseParser
{
    const CITY_RESPONSE_FIELD_NAME = 'city';
    const REGION_RESPONSE_FIELD_NAME = 'region_name';
    const COUNTRY_CODE_RESPONSE_FIELD_NAME = 'country_code';

    public function parse(Response $response) {
        $body = json_decode($response->getBody(), true);

        $city = $body[self::CITY_RESPONSE_FIELD_NAME];
        $region = $body[self::REGION_RESPONSE_FIELD_NAME];
        $country = $body[self::COUNTRY_CODE_RESPONSE_FIELD_NAME];

        return new Region($city, $region, $country);
    }
}
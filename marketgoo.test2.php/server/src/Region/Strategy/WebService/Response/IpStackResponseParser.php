<?php

namespace MarketgooApp\Region\Strategy\WebService\Response;

class IpStackResponseParser extends ResponseParser
{
    const CITY_FIELD_NAME = 'city';
    const REGION_FIELD_NAME = 'region_name';
    const COUNTRY_CODE_FIELD_NAME = 'country_code';

    protected function getCityFieldName() {
        return self::CITY_FIELD_NAME;
    }

    protected function getRegionFieldName() {
        return self::REGION_FIELD_NAME;
    }

    protected function getCountryCodeFieldName() {
        return self::COUNTRY_CODE_FIELD_NAME;
    }
}
<?php

namespace MarketgooApp\Region\Strategy\WebService\Response;

use GuzzleHttp\Psr7\Response;
use MarketgooApp\Model\Region\Region;

// TODO esta clase no está completa, sirve como ejemplo si se deseara utilizar un servicio diferente
class DbIpResponseParser extends ResponseParser
{
    public function parse(Response $response) {
        return new Region('Matalascañas', 'Huelva', 'ES');
    }

    protected function getCityFieldName() {
        return '';
    }

    protected function getRegionFieldName() {
        return '';
    }

    protected function getCountryCodeFieldName() {
        return '';
    }
}
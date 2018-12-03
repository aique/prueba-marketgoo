<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use GuzzleHttp\Psr7\Response;
use MarketgooApp\Model\Region\Region;

// TODO esta clase no está completa, sirve como ejemplo si se deseara utilizar un servicio diferente
class DbIpResponseParser implements ResponseParser
{
    public function parse(Response $response) {
        return new Region('Matalascañas', 'Huelva', 'ES');
    }
}
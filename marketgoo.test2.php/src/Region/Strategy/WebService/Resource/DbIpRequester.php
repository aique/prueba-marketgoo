<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use GuzzleHttp\Psr7\Response;
use MarketgooApp\Region\Strategy\WebService\WebServiceRequesterImp;

// TODO esta clase no está completa, sirve como ejemplo si se deseara utilizar un servicio diferente
class DbIpRequester extends WebServiceRequesterImp
{
    const CONF_NAME = 'db_ip';

    public function __construct() {
        $this->parser = new DbIpResponseParser();
    }

    public function makeRequest($ip) {
        return new Response();
    }

    public function getConfName() {
        return self::CONF_NAME;
    }
}
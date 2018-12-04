<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use GuzzleHttp\Client;
use MarketgooApp\Region\Strategy\WebService\Response\IpStackResponseParser;
use MarketgooApp\Region\Strategy\WebService\WebServiceRequesterImp;

class IpStackRequester extends WebServiceRequesterImp
{
    const CONF_NAME = 'ip_stack';

    public function __construct() {
        $this->parser = new IpStackResponseParser();
    }

    public function makeRequest($ip) {
        $client = new Client();

        $response = $client->request('GET', $this->url.'/'.$ip, [
            'query' => [
                'access_key' => $this->key
            ]
        ]);

        return $response;
    }

    public function getConfName() {
        return self::CONF_NAME;
    }
}
<?php

namespace MarketgooApp\Region\Strategy\WebService;

abstract class WebServiceRequesterImp implements WebServiceRequester
{
    const API_URL_CONF_NAME = 'url';
    const CONF_NAME = 'key';

    protected $url;
    protected $key;

    /** @var ResponseParser */
    protected $parser;

    public function request($ip) {
        $response = $this->makeRequest($ip);

        if ($response->getStatusCode() != 200) {
            return null;
        }

        return $this->parser->parse($response);
    }

    public abstract function makeRequest($ip);
    public abstract function getConfName();

    public function setUrl($url): void {
        $this->url = $url;
    }

    public function setKey($key): void {
        $this->key = $key;
    }
}
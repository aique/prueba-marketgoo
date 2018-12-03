<?php

namespace MarketgooApp\Region\Strategy\WebService\Resource;

use GuzzleHttp\Psr7\Response;

interface ResponseParser
{
    function parse(Response $response);
}
<?php

namespace MarketgooApp\Request;

use Psr\Http\Message\ServerRequestInterface;

class RequestQueryParameter
{
    /** @var ServerRequestInterface */
    private $request;

    public function __construct(ServerRequestInterface $request) {
        $this->request = $request;
    }

    public function getQueryParam($name, $default = null) {
        $queryParams = $this->request->getQueryParams();

        if (isset($queryParams[$name])) {
            return $queryParams[$name];
        }

        return $default;
    }
}
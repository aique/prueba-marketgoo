<?php

namespace MarketgooApp\Region\Strategy\WebService;

use MarketgooApp\Conf\ConfReader;
use MarketgooApp\Region\Strategy\WebService\Resource\DbIpRequester;
use MarketgooApp\Region\Strategy\WebService\Resource\IpStackRequester;

class RequesterFactory
{
    const IP_STACK_REQUESTER = 'ip_stack';
    const DB_IP_REQUESTER = 'db_ip';

    const DEFAULT_REQUESTER = self::IP_STACK_REQUESTER;

    private $resource;

    public function __construct($resource = self::DEFAULT_REQUESTER) {
        $this->resource = $resource;
    }

    public function create() {
        switch ($this->resource) {
            case self::IP_STACK_REQUESTER:
                return $this->createRequester(new IpStackRequester());
            case self::DB_IP_REQUESTER:
                return $this->createRequester(new DbIpRequester());
            default:
                return $this->createRequester(new IpStackRequester());
        }
    }

    private function createRequester(WebServiceRequesterImp $requester) {
        $config = $this->readConfig($requester->getConfName());
        $requester->setUrl($config[WebServiceRequesterImp::API_URL_CONF_NAME]);
        $requester->setKey($config[WebServiceRequesterImp::CONF_NAME]);

        return $requester;
    }

    private function readConfig($name) {
        $confReader = new ConfReader();
        return $confReader->getValue($name);
    }

    public function invalidResource($resource) {
        return !in_array($resource, [
            self::IP_STACK_REQUESTER,
            self::DB_IP_REQUESTER
        ]);
    }
}
<?php

namespace MarketgooApp\Region\Strategy\WebService;

use MarketgooApp\Region\Strategy\WebService\Resource\IpStackRequester;
use MarketgooApp\Region\WebService\Resource\DbIpRequester;

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
                return new IpStackRequester();
            case self::DB_IP_REQUESTER:
                return new DbIpRequester();
            default:
                return new IpStackRequester();
        }
    }

    public function invalidResource($resource) {
        return !in_array($resource, [
            self::IP_STACK_REQUESTER,
            self::DB_IP_REQUESTER
        ]);
    }
}
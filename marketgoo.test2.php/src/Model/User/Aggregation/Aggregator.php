<?php

namespace MarketgooApp\Model\User\Aggregation;

interface Aggregator
{
    function aggregate($user);
}
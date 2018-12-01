<?php

namespace MarketgooApp\Model\Aggregation;

interface Aggregator
{
    function aggregate($user);
}
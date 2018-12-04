<?php

namespace MarketgooTest\Region\Strategy;

use phpDocumentor\Reflection\DocBlock\Tags\Factory\Strategy;
use PHPUnit\Framework\TestCase;

abstract class StrategyFactoryTest extends TestCase
{
    /** @var StrategyFactory */
    protected $strategyFactory;
    /** @var Strategy */
    protected $strategy;

    public function testCreate() {
        $this->setUpStrategyFactory();
        $this->setUpExpectedStrategy();
        $this->assertEquals($this->strategy, $this->strategyFactory->create());
    }

    protected abstract function setUpStrategyFactory();
    protected abstract function setUpExpectedStrategy();
}
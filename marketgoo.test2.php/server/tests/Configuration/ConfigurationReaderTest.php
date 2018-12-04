<?php

namespace MarketgooTest\Configuration;

use MarketgooApp\Configuration\ConfigurationReader;
use PHPUnit\Framework\TestCase;

class ConfigurationReaderTest extends TestCase
{
    const TEST_CONFIG_FILE_PATH = 'tests/Resources/conf.test.json';

    /** @var ConfigurationReader */
    private $confReader;

    protected function setUp() {
        $this->confReader = new ConfigurationReader(self::TEST_CONFIG_FILE_PATH);
    }

    public function testGetValue() {
        $webServiceConf = $this->confReader->getValue('web_service');

        $this->assertNotNull($webServiceConf);
        $this->assertEquals('http://api.ipstack.com', $webServiceConf['url']);
        $this->assertEquals('12345qwerty', $webServiceConf['key']);

        $this->assertNull($this->confReader->getValue('unexistent_value'));
    }
}

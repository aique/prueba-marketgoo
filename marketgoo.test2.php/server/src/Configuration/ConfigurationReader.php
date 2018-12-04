<?php

namespace MarketgooApp\Configuration;

class ConfigurationReader
{
    const DEFAULT_CONF_FILE_PATH = 'conf/conf.json';

    private $configPath;

    public function __construct($configPath = self::DEFAULT_CONF_FILE_PATH) {
        $this->configPath = $configPath;
    }

    public function getValue($name) {
        $conf = json_decode(file_get_contents($this->configPath), true);

        if (isset($conf[$name])) {
            return $conf[$name];
        }

        return null;
    }
}
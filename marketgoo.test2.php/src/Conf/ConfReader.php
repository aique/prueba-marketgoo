<?php

namespace MarketgooApp\Conf;

class ConfReader
{
    const DEFAULT_CONF_FILE_PATH = 'conf/conf.json';

    private $configPath;

    public function __construct($configPath = self::DEFAULT_CONF_FILE_PATH) {
        $this->configPath = $configPath;
    }

    public function getValue($name) {
        $conf = json_decode(file_get_contents($this->configPath), true);

        foreach ($conf as $key => $value) {
            if ($key == $name) {
                return $value;
            }
        }

        return null;
    }
}
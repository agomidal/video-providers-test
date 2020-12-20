<?php

namespace App\Tests\Unit\Config;

use PHPUnit\Framework\TestCase;
use App\Config\ConfigurationLoader;
use App\Utils\Parsing\YAMLFileParser;

class ConfigurationLoaderTest extends TestCase {

    private $configurationLoader;

    protected function setUp() : void {
        parent::setUp ();
        $this->configurationLoader = new ConfigurationLoader(new YAMLFileParser(), '/var/app');
    }

    public function test_configuration_loads_properly() {
        $configFileName = 'providers.yaml';
        $config = $this->configurationLoader->load($configFileName);

        $this->assertNotEmpty($config);

    }
}
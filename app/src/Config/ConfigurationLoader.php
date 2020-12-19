<?php

namespace App\Config;

use App\Utils\Parsing\YAMLFileParser;

class ConfigurationLoader {

    const CONFIG_DIR = 'config' . DIRECTORY_SEPARATOR;
    
    protected $fileParser = null;
    
    protected $baseConfigPath = '';
    protected $parsedConfig = [];
    
    public function __construct(YAMLFileParser $fileParser, String $kernelProjectDir) {
        $this->fileParser = $fileParser;
        $this->baseConfigPath = $kernelProjectDir . DIRECTORY_SEPARATOR . self::CONFIG_DIR;
    }

    public function load(String $fileName) : array {
        return $this->fileParser->parse($this->baseConfigPath . $fileName);
    }

    public function getConfigurationDir() : String {
        return $this->baseConfigPath();
    }
}
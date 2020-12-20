<?php

namespace App\Video\SourceReaders;

use App\Video\SourceReaders\VideoSourceReaderInterface;
use App\Normalization\NormalizerInterface;
use App\Utils\Parsing\FileParserInterface; 
use App\Config\ConfigurationLoader;

abstract class AbstractVideoSourceReader implements VideoSourceReaderInterface {

    const PROVIDERS_CONFIG_FILE = 'providers.yaml';

    protected $providerName = '';
    protected $fileParser = null;
    protected $videoNormalizer = null;
    protected $providerConfig = [];

    public function __construct(String $providerName, ConfigurationLoader $configurationLoader, FileParserInterface $fileParser, NormalizerInterface $videoNormalizer) {        
        $this->providerName = $providerName;
        $this->fileParser = $fileParser;
        $this->videoNormalizer = $videoNormalizer;
        $this->providerConfig = $this->loadConfig($configurationLoader);
        
    }

    protected function loadConfig(ConfigurationLoader $configurationLoader) {
        return $configurationLoader->load(self::PROVIDERS_CONFIG_FILE)['providers'][$this->providerName];
    }

    public abstract function read() : array; 

}
<?php

namespace App\Factory;

use App\Video\Providers\VideoProviderInterface;
use App\Utils\Parsing\FileParserInterface;
use App\Utils\Parsing\YAMLFileParser;

class VideoProviderFactory {

    protected $instances = [];
    protected $providersConfig = [];


    
    // protected $parserFactory = null;
    // protected $videoSourceNormalizer = null;

// -->FileParserFactory $parserFactory, VideoSourceNormalizerFactory $normalizerFactory
// hacerlos estaticos para facilitar su uso y nunca necesitaran estado son clases muy simples
    public function __construct(ConfigurationLoader $config, String $kernelRootDir) {
        // $this->parserFactory = $parserFactory;
        // $this->normalizerFactory = $normalizerFactory;
        $this->providersConfig = $config->load('providers.yaml');
        $this->kernelRootDir = $kernelRootDir;
    }
    

    public function makeProvider(String $providerName) : VideoProviderInterface {
        
        $this->validateProvider($providerName);

        if ($this->instances[$providerName] !== null) {
            return $this->instances[$providerName];
        }
        
        //read config for providerName
        $providerConfig = $this->providersConfig[$providerName];

        //call makeFileParser for corresponding format
        
        $fileParser = $this->makeSourceFileParser($providerConfig['filename']);
        //call makeVideoNormalizer for corresponding normalization
        $providerNormalizer = $this->makeProviderNormalizer($providerName);
        //instantiate and return the instance
        $sourceFilePath = $this->kernelRootDir . $providerConfig['sources_dir'] . DIRECTORY_SEPARATOR . $providerConfig['filename'];
        $instance = new $providerConfig['class']($fileParser, $providerNormalizer, $sourceFilePath);
        static::$instances[$providerName] = $instance;
        return $instance;

        // probably need additional logic to handle remote file sources 
        // in order to instantiate them (FTP Manager and other dependencias
        //must be handled)
    }

    // Static call to to other factory, same for normalizer
    private function makeSourceFileParser(String $fileName) : FileParserInterface {
        $format = preg_match('/.+\.(.+)$/', $fileName)[1];
        // get file parser from factory and return it
        return FileParserFactory::makeParser($format);
    }

    private function makeProviderNormalizer($providerName) {
        return ProviderNormalizerFactory::makeNormalizer($providerName);
    }

    private function validateProvider(String $providerName) {
        if (!in_array($providerName, array_keys($this->providersConfig['providers']))) {
            throw new \Exception('Unknown provider. It must be registered at config/providers.yaml');
        }
    }
}
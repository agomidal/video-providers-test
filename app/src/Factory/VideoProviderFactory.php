<?php

namespace App\Factory;

use App\Video\Providers\VideoProviderInterface;
use App\Utils\Parsing\FileParserInterface;
use App\Utils\Parsing\YAMLFileParser;

/**
 * Dummy unfinished class. Use as an idea of how the other approach 
 * I talk about in the readme.md was about to be implemented.
 */
class VideoProviderFactory {

    protected $instances = [];
    protected $providersConfig = [];

    public function __construct(ConfigurationLoader $config, String $kernelProjectDir) {
        $this->providersConfig = $config->load('providers.yaml');
        $this->kernelProjectDir = $kernelProjectDir;
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
        // in order to instantiate them (FTP Manager and other dependencies
        //must be handled)
    }

    // Static call to to other factory to ask for corresponding parser 
    // given the file format
    private function makeSourceFileParser(String $fileName) : FileParserInterface {
        $format = preg_match('/.+\.(.+)$/', $fileName)[1];
        // get file parser from factory and return it
        return FileParserFactory::makeParser($format);
    }

    // Static call to to other factory to ask for corresponding normalizer 
    // given the provider name
    private function makeProviderNormalizer($providerName) {
        return ProviderNormalizerFactory::makeNormalizer($providerName);
    }

    private function validateProvider(String $providerName) {
        if (!in_array($providerName, array_keys($this->providersConfig['providers']))) {
            throw new \Exception('Unknown provider. It must be registered at config/providers.yaml');
        }
    }
}
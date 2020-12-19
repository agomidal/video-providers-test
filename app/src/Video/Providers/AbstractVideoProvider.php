<?php

namespace App\Video\Providers;

use App\Utils\Parsing\FileParserInterface; 
use App\Video\Providers\VideoProviderInterface;
use App\Normalization\NormalizerInterface;
use App\Config\ConfigurationLoader;
use App\Entity\Video;

abstract class AbstractVideoProvider implements VideoProviderInterface {    
    const PROVIDER_NAME = '';
    const PROVIDERS_CONFIG_FILE = 'providers.yaml';
    
    protected $fileParser = null;
    protected $videoNormalizer = null;
    protected $providerConfig = [];
    protected $sourceFilePath = '';

    public function __construct(ConfigurationLoader $configurationLoader, FileParserInterface $fileParser, NormalizerInterface $videoNormalizer) {
        
        //TODO crear nueva dependencia videoSource donde viva la logica
        //de cargar config y leer fichero. A ese le entraria el configloader y 
        //el parserinterface con el normalizer. Aeste le entraria la dependencia de ese videoSource
        
        $this->fileParser = $fileParser;
        $this->videoNormalizer = $videoNormalizer;
        $this->providerConfig = $this->loadConfig($configurationLoader);
        $this->sourceFilePath = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . $this->providerConfig['source-path'];

    }

    protected function loadConfig(ConfigurationLoader $configurationLoader) {
        return $configurationLoader->load(self::PROVIDERS_CONFIG_FILE)['providers'][static::PROVIDER_NAME];
    }

    /**
     * Hydrates the parsed file data into the corresponding model objects.
     * 
     * @return Video[] A collection of Video Model objects 
     */
    public function provide() {
        $parsedSource = $this->fileParser->parse($this->sourceFilePath);
        $normalizedSources = $this->videoNormalizer->normalize($parsedSource);

        $videos = [];
        
        foreach ($normalizedSources as $video) {
            $newVideo = new Video();
            $newVideo
                ->setName($video['name'])
                ->setUrl($video['url']);
            if (!empty($video['tags'])) {
                $newVideo->setTags($video['tags']);
            }            
            $videos[] = $newVideo;
        }

        return $videos;
    }
    
}
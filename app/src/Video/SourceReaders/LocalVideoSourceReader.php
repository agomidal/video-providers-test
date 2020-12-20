<?php

namespace App\Video\SourceReaders;

use App\Video\SourceReaders\AbstractVideoSourceReader;
use App\Utils\Parsing\FileParserInterface; 
use App\Normalization\NormalizerInterface;
use App\Config\ConfigurationLoader;

class LocalVideoSourceReader extends AbstractVideoSourceReader {

    public function __construct(String $providerName, ConfigurationLoader $configurationLoader, FileParserInterface $fileParser, NormalizerInterface $videoNormalizer) {
        parent::__construct($providerName, $configurationLoader, $fileParser, $videoNormalizer);
    }

    public function read() : array {
        $sourceFilePath = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . $this->providerConfig['source-path'];

        $parsedSourceFile = $this->fileParser->parse($sourceFilePath);
        return $this->videoNormalizer->normalize($parsedSourceFile);
    }

}
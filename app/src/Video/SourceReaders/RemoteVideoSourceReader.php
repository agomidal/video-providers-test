<?php

namespace App\Video\SourceReaders;

use App\Video\SourceReaders\AbstractVideoSourceReader;
use App\Config\ConfigurationLoader;
use App\Normalization\NormalizerInterface;
use App\Utils\Parsing\FileParserInterface; 

/**
 * NOTE: Any RemoteResourceDownloader has been implemented
 * This service would be responsable of downloading the remote 
 * file before asking the parser to parse it.
 */

class RemoteVideoSourceReader extends AbstractVideoSourceReader {

    protected $remoteDownloader = null;

    // RemoteResourceDownloader $remoteDownloader
    public function __construct(String $providerName, ConfigurationLoader $configurationLoader, FileParserInterface $fileParser, NormalizerInterface $videoNormalizer, RemoteResourceDownloaderInterface $remoteDownloader) {
        parent::__construct($providerName, $configurationLoader, $fileParser, $videoNormalizer);

        $this->remoteDownloader = $remoteDownloader;
    }

    public function read() : array {
        
        // DUMMY CODE

        $filePath = $this->remoteDownloader->download(); //download file and return its path
        $parsedSourceFile = $this->fileParser->parse($filePath);
        return $this->videoNormalizer->normalize($parsedSourceFile);
    }

    private function downloadRemoteResource() {
        //get source endpoint, filename, path to store locally after
        //retrieval, etc. from providers configuration object
        return $this->remoteDownloader->download(/*Config data */);
    }

}
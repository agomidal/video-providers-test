<?php

namespace App\Video\Providers;

use App\Video\Providers\AbstractVideoProvider;
use App\Utils\Parsing\YAMLFileParser;
use App\Normalization\Video\FlubVideoSourceNormalizer;
use App\Config\ConfigurationLoader;

class FlubVideoProvider extends AbstractVideoProvider {
    const PROVIDER_NAME = 'flub';

    public function __construct(ConfigurationLoader $configurationLoader, YAMLFileParser $fileParser, FlubVideoSourceNormalizer $videoNormalizer) {
        parent::__construct($configurationLoader, $fileParser, $videoNormalizer);
    }
}
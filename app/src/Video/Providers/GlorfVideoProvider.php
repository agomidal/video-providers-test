<?php

namespace App\Video\Providers;

use App\Video\Providers\AbstractVideoProvider;
use App\Utils\Parsing\JSONFileParser;
use App\Normalization\Video\GlorfVideoSourceNormalizer;
use App\Config\ConfigurationLoader;

class GlorfVideoProvider extends AbstractVideoProvider {
    const PROVIDER_NAME = 'glorf';

    public function __construct(ConfigurationLoader $configurationLoader, JSONFileParser $fileParser, GlorfVideoSourceNormalizer $videoNormalizer) {
        parent::__construct($configurationLoader, $fileParser, $videoNormalizer);
    }
}
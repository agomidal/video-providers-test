<?php

namespace App\Normalization\Video;

use App\Normalization\Video\AbstractVideoSourceNormalizer;
use App\Entity\Video;

final class FlubVideoSourceNormalizer extends AbstractVideoSourceNormalizer {

    const NORMALIZATION_MAP = [
        'labels' => 'tags',
    ];
}
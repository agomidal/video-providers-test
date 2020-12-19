<?php

namespace App\Normalization\Video;

use App\Normalization\Video\AbstractVideoSourceNormalizer;
use App\Entity\Video;

final class GlorfVideoSourceNormalizer extends AbstractVideoSourceNormalizer {

    const NORMALIZATION_MAP = [
        'title' => 'name'
    ];



    protected function prepareData(array $dataToNormalize) : array {
        return $dataToNormalize['videos'];
    }
}
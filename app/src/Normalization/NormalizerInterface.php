<?php

namespace App\Normalization;

interface NormalizerInterface {
    
    public function normalize(array $dataToNormalize);
}

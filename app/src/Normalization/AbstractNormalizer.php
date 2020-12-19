<?php

namespace App\Normalization;

use App\Normalization\NormalizerInterface;

/**
 * TemplateMethod class for normaliztion.
 */
abstract class AbstractNormalizer implements NormalizerInterface {
    
    public function normalize(array $dataToNormalize) {
        $dataToNormalize = $this->prepareData($dataToNormalize);

        $normalizedItems = [];

        foreach ($dataToNormalize as $item) {
            $normalizedItems[] = $this->normalizeItem($item);
        }
        return $normalizedItems;
    }
    
    /**
     * Perform any actions on the data before beginning to normalize 
     * it (remove unwanted indexes, exceding array sublevels, etc.)
     */
    protected function prepareData(array $dataToNormalize) : array {
        return $dataToNormalize;
    }

    protected abstract function normalizeItem(array $item);
}

<?php

namespace App\Normalization\Video;

use App\Normalization\AbstractNormalizer;

abstract class AbstractVideoSourceNormalizer extends AbstractNormalizer {
    const NORMALIZATION_MAP = [
        'providerKey' => 'normalizedKey'
    ];

    protected function normalizeItem(array $video) {
        $normalizedVideo = [];

        foreach ($video as $attributeName => $attributeValue) {
            $normalizedName = $this->normalizeAttributeName($attributeName);
            $normalizedValue = $this->normalizeAttributeValue($normalizedName, $attributeValue);

            $normalizedVideo[$normalizedName] = $normalizedValue;
        }

        return $normalizedVideo;
    }

    protected function normalizeAttributeName(String $attributeName) {
        if (in_array($attributeName, array_keys(static::NORMALIZATION_MAP))) {           
            $normalizedName = static::NORMALIZATION_MAP[$attributeName];
        } 
        else {
            $normalizedName = $attributeName;
        }

        return $normalizedName;
    }

    protected function normalizeAttributeValue($normalizedAttributeName, $attributeValue) {
        switch ($normalizedAttributeName) {
            case 'tags':
                $normalizedValue = is_array($attributeValue) ? $attributeValue : explode(', ', $attributeValue);
            break;
            default:
                $normalizedValue = $attributeValue;
        }

        return $normalizedValue;
    }
}
<?php

namespace App\Tests\Unit\Normalization\Video;

use PHPUnit\Framework\TestCase;
use App\Normalization\Video\FlubVideoSourceNormalizer;

class FlubVideoSourceNormalizerTest extends TestCase {

    private $normalizer;

    protected function setUp() : void {
        parent::setUp ();
        $this->normalizer = new FlubVideoSourceNormalizer();
    }

    /**
     * @dataProvider providerParsedItems
     */
    public function test_normalize($parsedItem) {
        // normalizer expects array of parsed items
        $parsed[] = $parsedItem;
        $output = $this->normalizer->normalize($parsed);

        $this->assertNotContains('labels', array_keys($output[0]));

        if (isset($parsed[0]['labels'])) {
            $this->assertArrayHasKey('tags', $output[0]);
            $this->assertIsArray($output[0]['tags']);
        }
    }

    public function providerParsedItems() {

        $parsedItems[] = [
            'labels' => 'cats, cute, funny',
            'name' => 'funny cats',
            'url' => 'http://glorf.com/videos/jr7sfg4sj6'
        ];

        $parsedItems[] = [
            'name' => 'boring cats',
            'url' => 'http://glorf.com/videos/sd89g6gg6'
        ];

        return array($parsedItems);
    }
}
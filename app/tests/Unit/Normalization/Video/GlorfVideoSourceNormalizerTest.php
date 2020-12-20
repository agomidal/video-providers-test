<?php

namespace App\Tests\Unit\Normalization\Video;

use PHPUnit\Framework\TestCase;
use App\Normalization\Video\GlorfVideoSourceNormalizer;

class GlorfVideoSourceNormalizerTest extends TestCase {

    private $normalizer;

    protected function setUp() : void {
        parent::setUp ();
        $this->normalizer = new GlorfVideoSourceNormalizer();
    }

    /**
     * @dataProvider providerParsedItems
     */
    public function test_normalize($parsedItem) {
        $parsed['videos'] = $parsedItem;
        $output = $this->normalizer->normalize($parsed);

        $this->assertNotContains('title', array_keys($output[0]));
        $this->assertContains('name', array_keys($output[0]));

        $this->assertIsArray($output[0]['tags']);
    }

    public function providerParsedItems() {

        $parsedItems['videos'][] = [
            'tags' => 'cats, cute, funny',
            'title' => 'funny cats',
            'url' => 'http://glorf.com/videos/jr7sfg4sj6'
        ];

        $parsedItems['videos'][] = [
            'title' => 'boring cats',
            'url' => 'http://glorf.com/videos/sd89g6gg6'
        ];
        
        return array($parsedItems);
    }
}
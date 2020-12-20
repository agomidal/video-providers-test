<?php

namespace App\Tests\Functional\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use App\Config\ConfigurationLoader;
use App\Utils\Parsing\JSONFileParser;
use App\Utils\Parsing\YAMLFileParser;
use App\Video\Providers\VideoProvider;
use App\Video\SourceReaders\LocalVideoSourceReader;
use App\Normalization\Video\GlorfVideoSourceNormalizer;
use App\Normalization\Video\FlubVideoSourceNormalizer;

/**
 * To my understanding, functional tests test everything 
 * which gets executed during the user interaction with our 
 * application (http request, command executed, etc.)
 * 
 * I've seen several examples for functional testing web applications,
 * but none for a Command line app.
 * 
 * So, for this functional test, I'm assuming that what I need 
 * to test is the whole process, forgive me if I'm mistaken and 
 * this is not what you were asking for.
 */

 class ImportCommandFunctionalTest extends KernelTestCase {
    
    // protected $configurationLoader;
    static $kernel;

    public function setUp(): void
    {
        static::$kernel = static::createKernel();
        $application = new Application(static::$kernel);        
    }

    public function test_glorf_provider_full_process() {

        $providerName = 'glorf';
        $configurationLoader = new ConfigurationLoader(new YAMLFileParser(), static::$kernel->getProjectDir());
        $parser = new JSONFileParser();
        $normalizer = new GlorfVideoSourceNormalizer();
        $sourceReader = new LocalVideoSourceReader($providerName, $configurationLoader, $parser, $normalizer);

        $videoProvider = new VideoProvider($sourceReader);
        $videos = $videoProvider->provide();

        $this->assertVideoProviderOutput($videos);
    }

    public function test_flub_provider_full_process() {

        $providerName = 'flub';
        $configurationLoader = new ConfigurationLoader(new YAMLFileParser(), static::$kernel->getProjectDir());
        $parser = new YAMLFileParser();
        $normalizer = new FlubVideoSourceNormalizer();
        
        $sourceReader = new LocalVideoSourceReader($providerName, $configurationLoader, $parser, $normalizer);

        $videoProvider = new VideoProvider($sourceReader);
        $videos = $videoProvider->provide();

        $this->assertVideoProviderOutput($videos);
    }

    private function assertVideoProviderOutput(array $videos) {
        $this->assertIsArray($videos);
        $this->assertNotEmpty($videos); //assuming we will never have empty source file

        $this->assertEquals(get_class($videos[0]), 'App\Entity\Video');
    }
 }
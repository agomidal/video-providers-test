<?php

namespace App\Tests\EndToEnd;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AppTest extends KernelTestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    public function setUp(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('import');
        $this->commandTester = new CommandTester($command);
    }

    public function test_it_imports_from_glorf_correctly()
    {
        // When executing the command to import videos from "glorf"
        $this->commandTester->execute([
            'provider' => 'glorf',
        ]);

        // The output should contain the correct lines
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('importing: "science experiment goes wrong"; Url: http://glorf.com/videos/3; Tags: microwave,cats,peanutbutter', $output);
        $this->assertStringContainsString('importing: "amazing dog can talk"; Url: http://glorf.com/videos/4; Tags: dog,amazing', $output);
    }

    public function test_it_imports_from_flub_correctly()
    {
        // When executing the command to import videos from "glorf"
        $this->commandTester->execute([
            'provider' => 'flub',
        ]);

        // The output should contain the correct lines
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('importing: "funny cats"; Url: http://glorf.com/videos/asfds.com; Tags: cats,cute,funny', $output);
        $this->assertStringContainsString('importing: "more cats"; Url: http://glorf.com/videos/asdfds.com; Tags: cats,ugly,funny', $output);
        $this->assertStringContainsString('importing: "lots of dogs"; Url: http://glorf.com/videos/asasddfds.com; Tags: dogs,cute,funny', $output);
        $this->assertStringContainsString('importing: "bird dance"; Url: http://glorf.com/videos/q34343.com; Tags: ', $output);
    }

    public function test_it_errors_when_input_provider_does_not_exist()
    {
        // When executing the command to import videos from "glorf"
        $this->commandTester->execute([
            'provider' => 'unexisting-provider',
        ]);

        // The output should contain the correct lines
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('Unknown provider "unexisting-provider"', $output);
    }
}
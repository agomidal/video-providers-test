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
        When executing the command to import videos from "glorf"
        $this->commandTester->execute([
            'provider' => 'glorf',
        ]);

        The output should contain the correct lines
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('importing: "science experiment goes wrong"; Url: http://glorf.com/videos/3; Tags: microwave,cats,peanutbutter', $output);
        $this->assertStringContainsString('importing: "amazing dog can talk"; Url: http://glorf.com/videos/4; Tags: dog,amazing', $output);
    }
}
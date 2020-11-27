<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    protected static $defaultName = 'import';

    protected function configure()
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'Name of the video provider');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>Import command is not yet implemented</error>');

        return Command::FAILURE;
    }
}
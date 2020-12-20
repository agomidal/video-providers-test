<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
// use Doctrine\ORM\EntityManagerInterface;

class ImportCommand extends Command
{
    protected static $defaultName = 'import';

    protected $availableProviders = [];
    
    // protected $entityManager;

    // public function __construct(/*EntityManagerInterface $entityManager*/VideoProviderFactory $providerFactory) {
    public function __construct(String $entityManager, array $availableProviders) {
        // $this->entityManager = $entityManager;
        // $this->providerFactory = $providerFactory;
        // dd($availableProviders);
        $this->availableProviders = $availableProviders;

        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'Name of the video provider');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $videoProvider = $this->parseProviderFromAvailableProviders($input->getArgument('provider'));

            $videos = $videoProvider->provide();

            $this->persistVideos($videos, $output);

            return Command::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln('<error>' . $ex->getMessage() . '</error>');
            return Command::FAILURE;
        }

        
    }

    private function parseProviderFromAvailableProviders(String $inputProvider) {
        // performance wise, it would be better to avoid array_filter in favor of 
        // a manual loop which stops looping after finding the desired value.
        // We won't be having enough providers in order for that to make a difference though
        $videoProvider = array_filter($this->availableProviders, function($provider) use ($inputProvider) {
            return key($provider) === $inputProvider;
        });

        return array_pop($videoProvider)[$inputProvider];
    }

    /**
     * Code responsable of persisting to database is commented
     */
    private function persistVideos(array $videos, OutputInterface $output) {
        //the code responsible of performing database actions 
        //(bulking the database statements, persisting objetcs, etc)
        //should be moved to another service, which would be the one 
        //we would inject here as a dependency instead of the EntityManager
        $bulkInsertAmountStatements = 100;

        for ($i = 0; $i < count($videos); $i++) {
            $video = $videos[$i];
            $output->writeln('importing: ' . '"' . $video->getName() . '"; Url: ' . $video->getUrl() . '; Tags: ' . implode(',', $video->getTags()));
            // $this->entityManager->persist($video);
            if ($i % $bulkInsertAmountStatements === 0) {
                // $this->entityManager->flush();
                // $this->entityManager->clear();
            }
        }

        // $this->entityManager->flush();
        // $this->entityManager->clear();
    }
}
<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\ORM\EntityManagerInterface;
use App\Video\Providers\VideoProviderInterface;
// use App\Factory\VideoProviderFactory;

class ImportCommand extends Command
{
    protected static $defaultName = 'import';

    // protected $providerFactory = null;

    protected $availableProviders = [];
    

    // protected $entityManager;

    // public function __construct(/*EntityManagerInterface $entityManager*/VideoProviderFactory $providerFactory) {
    public function __construct(String $entityManager, array $availableProviders) {
        // $this->entityManager = $entityManager;
        // $this->providerFactory = $providerFactory;
        // dd($availableProviders);
        $this->availableProviders = $availableProviders;

        //No consigo obtener los providers tal cual como array asociativo
        //. Ver si realmente necesito la key del provider name y si es asi 
        // como ultima instancia parsearlo a mano

        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'Name of the video provider');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // $output->writeln('<error>Import command is not yet implemented</error>');

        // return Command::FAILURE;

        // php bin/console import provider


        // TODO CREAR UNA CLASE VideoImporter.php a la que llama este command
        // y la logica viviria alli. Pero entonces, como haria para ir imprimiendo por 
        // pantalla a medida que voy importando? Generadores php?

        try {
            // dd($this->availableProviders);

            $inputProvider = $input->getArgument('provider');

            // performance wise, it would be better to avoid array_filter in favor of 
            // a manual loop which stops looping after finding the desired value
            $videoProvider = array_filter($this->availableProviders, function($provider) use ($inputProvider) {
                return $provider::PROVIDER_NAME === $inputProvider;
            });
            $videoProvider = array_pop($videoProvider);
            $output->writeln('Hi');
            // dd($videoProvider);
            $videos = $videoProvider->provide();
// dd($videos);
// dd("hola");
            $this->persistVideos($videos, $output);


            return Command::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln('<error>' . $ex->getMessage() . '</error>');
            return Command::FAILURE;
        }

        
    }

    /**
     * Even though it is not a good practice to inject the whole container 
     * as a class dependency, I think that for the sake of scalability in this case 
     * it's better to do so. The reason is that the other option we would have is to 
     * inject (and, as a consequence, lazy load) any possible video provider class 
     * existing in our application, and the choosing which one to call.
     * That's not too bad if we only have a few providers, but if the providers list 
     * grows, then we might find ourselves lazy loading a lot of services when we would 
     * only run one at a time (the one corresponding to the 'provider' arg of the command).
     * 
     * On the opposite, if we have the whole container as dependency, we will only ask it 
     * for the provider that we need, which will cause to only instantiate that spcific one 
     * we asked for.
     * 
     * Nevertheless, if the providers list was really not expected to grow,
     * maybe the better option would be to just inject the few existing provider services
     * and then just call the one matching the current 'provider' argument.
     */
    // private function loadVideoProviderService(String $provider) : VideoProviderInterface {
        // switch ($provider) {
        //     case 'flub':
        //         // $videoProvider = ''; //get corresponding videoProvider class from container
        //         // break;
        //     case 'glorb':
        //         break;
        //     // additional provider cases would go here  
        //     default:
        //         $output->writeln('<error>Unknown provider.</error>');
        //         return Command::FAILURE;
        // }
        
        //get from the videoproviderfactory
        

        // return $this->container->get(self::VIDEO_PROVIDERS[$provider]);
    // }

    private function persistVideos(array $videos, OutputInterface $output) {
        // foreach ($videos as $video) {
        //     $this->entityManager->persist($video);
        //     $this->entityManager->flush();
        // }

        //the code responsible of performing database actions 
        //(bulking the database statements, persisting objetcs, etc)
        //should be moved to another service
        $bulkInsertAmountStatements = 100;

        for ($i = 0; $i < count($videos); $i++) {
            $video = $videos[$i];
            $output->writeln('importing: ' . '"' . $video->getName() . '"; Url: ' . $video->getUrl() . '; Tags: ' . implode(',', $video->getTags()));
            // $this->entityManager->persist($video);
            if ($i % $bulkInsertAmountStatements === 0) {
                // $this->entityManager->flush();
            }
        }

        // $this->entityManager->flush();
    }
}
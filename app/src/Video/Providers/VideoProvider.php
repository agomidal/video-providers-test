<?php

namespace App\Video\Providers;

use App\Video\SourceReaders\VideoSourceReaderInterface;
use App\Entity\Video;

class VideoProvider {    
    
    // protected $providerName = '';
    protected $sourceReader = null;

    public function __construct(VideoSourceReaderInterface $sourceReader) {
        // $this->providerName = $providerName;

        // $sourceReader->setProviderName($providerName);
        $this->sourceReader = $sourceReader;

    }

    

    /**
     * Hydrates the parsed file data into the corresponding model objects.
     * 
     * @return Video[] A collection of Video Model objects 
     */
    public function provide() {
        $sourceVideos = $this->sourceReader->read(); // parsed + normalized videos

        $videos = [];
        
        foreach ($sourceVideos as $video) {
            $newVideo = new Video();
            $newVideo
                ->setName($video['name'])
                ->setUrl($video['url']);
            if (!empty($video['tags'])) {
                $newVideo->setTags($video['tags']);
            }            
            $videos[] = $newVideo;
        }

        return $videos;
    }
    
}
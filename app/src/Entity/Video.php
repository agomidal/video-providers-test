<?php

namespace App\Entity;

// This would be the Doctrine model class, used 
// by the EntityManager to persist it to database
final class Video {
    /**
     * @DatabaseAnnotationsHere
     */
    protected $tags = [];
    /**
     * @DatabaseAnnotationsHere
     */
    protected $url = '';
    /**
     * @DatabaseAnnotationsHere
     */
    protected $name = '';

    public function setTags(array $tags) {
        $this->tags = $tags;
        return $this;
    }

    public function getTags() {
        return $this->tags;
    }

    public function addTag(String $tag) {
        $this->tags[] = $tag;
        return $this;
    }

    public function removeTag(String $tag) {
        $this->tags = array_filter($this->tags, function ($existingTag) use ($tag) {
            return $existingTag !== $tag;
        });
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl(String $url) {
        $this->url = $url;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(String $name) {
        $this->name = $name;
        return $this;
    }
    
    public function __toString() {
        return '"' . $$this->name . '"; Url: ' . $this->url . '; Tags: ' . implode(', ', $this->tags);
    }
}
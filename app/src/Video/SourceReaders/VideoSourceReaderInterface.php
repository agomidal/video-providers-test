<?php

namespace App\Video\SourceReaders;

interface VideoSourceReaderInterface {

    public function read() : array;

}
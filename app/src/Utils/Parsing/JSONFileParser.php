<?php

namespace App\Utils\Parsing;

use App\Utils\Parsing\FileParserInterface;

class JSONFileParser implements FileParserInterface {
    public function parse(String $filePath) : array {        
        $content = file_get_contents($filePath);
        return json_decode($content, true);
    }
}
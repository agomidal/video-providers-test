<?php

namespace App\Utils\Parsing;

use App\Utils\Parsing\AbstractFileParser;

class JSONFileParser extends AbstractFileParser {
    protected function parseFile(String $filePath) : array {        
        $content = file_get_contents($filePath);
        return json_decode($content, true);
    }
}
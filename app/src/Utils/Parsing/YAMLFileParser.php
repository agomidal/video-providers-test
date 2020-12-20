<?php

namespace App\Utils\Parsing;

use Symfony\Component\Yaml\Yaml;

use App\Utils\Parsing\AbstractFileParser;

class YAMLFileParser extends AbstractFileParser {
    public function parseFile(String $filePath) : array {
        return Yaml::parseFile($filePath);
    }
}
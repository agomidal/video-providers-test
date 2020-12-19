<?php

namespace App\Utils\Parsing;

use Symfony\Component\Yaml\Yaml;

use App\Utils\Parsing\FileParserInterface;

class YAMLFileParser implements FileParserInterface {
    public function parse(String $filePath) : array {
        return Yaml::parseFile($filePath);
    }
}
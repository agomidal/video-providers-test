<?php

namespace App\Utils\Parsing;

use App\Utils\Parsing\FileParserInterface;

abstract class AbstractFileParser implements FileParserInterface {

    public function parse(String $filePath) : array {
        if (!file_exists($filePath)) {
            throw new \Exception('File "' . $filePath . '" does not exist.');
        }

        return $this->parseFile($filePath);
    }

    protected abstract function parseFile(String $filePath) : array;
}
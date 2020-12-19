<?php

namespace App\Utils\Parsing;

use App\Utils\Parsing\FileParserInterface;

abstract class AbstractFileParser implements FileParserInterface {

    public abstract function parse(String $filePath) : array;

}
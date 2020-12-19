<?php

namespace App\Utils\Parsing;

interface FileParserInterface {

    public function parse(String $filePath) : array;

}
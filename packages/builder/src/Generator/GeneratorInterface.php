<?php

namespace Symfonic\Builder\Generator;

use PhpParser\Node;
use Symfonic\Builder\DTO\Option;

interface GeneratorInterface
{
    // Configure AST
    public function configure(Option $option) : Node;

    // generate File
    public function generate(Option $option);

    // Save file to disk
    public function save(string $filename, string $content);
}

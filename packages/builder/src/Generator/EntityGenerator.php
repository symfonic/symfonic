<?php

namespace Symfonic\Builder\Generator;

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;
use Symfonic\Builder\DTO\Option;
use Symfony\Component\Filesystem\Filesystem;
use function str_contains;

class EntityGenerator implements GeneratorInterface
{
    public function configure(Option $option): Node
    {
        $factory = new BuilderFactory;
        return $factory->namespace('App\\Entity')
            ->addStmt($factory->class($option->getCommandInput()))
            ->addStmt($factory->method())
            ->getNode();
    }

    public function generate(Option $option)
    {
        $printer = new Standard();
        $entity = $this->configure($option);
        $content = $printer->prettyPrintFile([$entity]);
        $this->save($option->getFilename(), $content);
    }

    public function save(string $filename, string $content): void
    {
        $filesystem = new Filesystem();
        $name = $this->resolveFileName($filename);
        $filesystem->dumpFile($name . '.php', $content);
    }

    private function resolveFileName(string $filename): string
    {
        if (!str_contains($filename, 'Entity')) {
            return $filename . 'Entity';
        }
        return $filename;
    }
}

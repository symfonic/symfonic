<?php

declare (strict_types=1);

use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter\Standard;
use Symfonic\Builder\Console\BuilderConsoleApplication;
use Symfonic\Builder\Generator\EntityGenerator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Filesystem\Filesystem;
use Symplify\ComposerJsonManipulator\Bundle\ComposerJsonManipulatorBundle;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\Json\JsonCleaner;
use Symplify\ComposerJsonManipulator\Json\JsonInliner;
use Symplify\EasyHydrator\EasyHydratorBundle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\PackageBuilder\Reflection\ClassLikeExistenceChecker;
use Symplify\SimplePhpDocParser\Bundle\SimplePhpDocParserBundle;

return static function (
    ContainerConfigurator $containerConfigurator
): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();
    $services->load('Symfonic\\Builder\\', __DIR__ . '/../src')
        ->exclude([
            __DIR__ . '/../src/HttpKernel',
        ]);
    $services->set(BuilderConsoleApplication::class);
    $services->alias(Application::class, BuilderConsoleApplication::class);
    $services->set(CommandNaming::class);
    $services->set(JsonFileManager::class);
    $services->set(ComposerJsonFactory::class);
    $services->set(JsonCleaner::class);
    $services->set(JsonInliner::class);
    $services->set(EntityGenerator::class);
    $services->set(EasyHydratorBundle::class);
    $services->set(SimplePhpDocParserBundle::class);
    $services->set(ClassLikeExistenceChecker::class);
    $services->set(BuilderFactory::class);
    $services->set(Filesystem::class);
    $services->set(Standard::class);
};

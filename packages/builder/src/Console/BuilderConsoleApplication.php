<?php

declare (strict_types=1);
namespace Symfonic\Builder\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class BuilderConsoleApplication extends Application
{
    /**
     * @param Command[] $commands
     */
    public function __construct(CommandNaming $commandNaming, array $commands)
    {
        foreach ($commands as $command) {
            $commandName = $commandNaming->resolveFromCommand($command);
            $command->setName($commandName);
            $this->add($command);
        }
        parent::__construct('Symfonic Builder');
    }
}

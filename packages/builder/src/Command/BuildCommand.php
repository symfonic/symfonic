<?php
declare (strict_types=1);

namespace Symfonic\Builder\Command;

use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter\Standard;
use Symfonic\Builder\CommandHandler;
use Symfonic\Builder\DTO\Option;
use Symfonic\Builder\Factory\EntityFactory;
use Symfonic\Builder\Generator\EntityGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;

final class BuildCommand extends Command
{
    private const ENTITY_SERVICE = 'entity';

    public function __construct(
        private ComposerJsonFactory $composerJsonFactory
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('build');
        $this->setDescription('generate entity');
        $this->addArgument('service', InputArgument::REQUIRED, 'name of entity to builder');
        $this->addArgument('title', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = $input->getArgument('service');
        $title = $input->getArgument('title');

        $composerJson = $this->composerJsonFactory->createFromFilePath(__DIR__ . '/../../../../composer.json');

        $option = new Option();
        $option->setCommandInput($title);
        $option->setService($service);
        $option->setComposerJson($composerJson);

        match ($service) {
            'entity' => (new EntityGenerator())->generate($option)
            // 'fixture' => new BuilderFixture($options)
        };

        return self::SUCCESS;
    }

}

<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
final class PushTagReleaseWorker implements \Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\Release\Process\ProcessRunner
     */
    private $processRunner;
    public function __construct(\Symplify\MonorepoBuilder\Release\Process\ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }
    /**
     * @param \PharIo\Version\Version $version
     */
    public function work($version) : void
    {
        $this->processRunner->run('git push --tags');
    }
    /**
     * @param \PharIo\Version\Version $version
     */
    public function getDescription($version) : string
    {
        return \sprintf('Push "%s" tag to remote repository', $version->getVersionString());
    }
}

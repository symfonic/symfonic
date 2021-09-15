<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
final class SetNextMutualDependenciesReleaseWorker implements \Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\DependencyUpdater
     */
    private $dependencyUpdater;
    /**
     * @var \Symplify\MonorepoBuilder\Package\PackageNamesProvider
     */
    private $packageNamesProvider;
    /**
     * @var \Symplify\MonorepoBuilder\Utils\VersionUtils
     */
    private $versionUtils;
    public function __construct(\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider $composerJsonProvider, \Symplify\MonorepoBuilder\DependencyUpdater $dependencyUpdater, \Symplify\MonorepoBuilder\Package\PackageNamesProvider $packageNamesProvider, \Symplify\MonorepoBuilder\Utils\VersionUtils $versionUtils)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->dependencyUpdater = $dependencyUpdater;
        $this->packageNamesProvider = $packageNamesProvider;
        $this->versionUtils = $versionUtils;
    }
    /**
     * @param \PharIo\Version\Version $version
     */
    public function work($version) : void
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);
        $this->dependencyUpdater->updateFileInfosWithPackagesAndVersion($this->composerJsonProvider->getPackagesComposerFileInfos(), $this->packageNamesProvider->provide(), $versionInString);
    }
    /**
     * @param \PharIo\Version\Version $version
     */
    public function getDescription($version) : string
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);
        return \sprintf('Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
    }
}

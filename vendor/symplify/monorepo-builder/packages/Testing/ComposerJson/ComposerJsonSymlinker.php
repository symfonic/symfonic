<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Testing\ComposerJson;

use MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Testing\PathResolver\PackagePathResolver;
use MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\MonorepoBuilder\Tests\Testing\ComposerJson\ComposerJsonSymlinkerTest
 */
final class ComposerJsonSymlinker
{
    /**
     * @var string
     */
    private const TYPE = 'type';
    /**
     * @var string
     */
    private const URL = 'url';
    /**
     * @var string
     */
    private const OPTIONS = 'options';
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\Testing\PathResolver\PackagePathResolver
     */
    private $packagePathResolver;
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider $composerJsonProvider, \Symplify\MonorepoBuilder\Testing\PathResolver\PackagePathResolver $packagePathResolver, \MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->packagePathResolver = $packagePathResolver;
        $this->jsonFileManager = $jsonFileManager;
    }
    /**
     * The relative to the local package is calculated by appending:
     * - the relative path from the target package to root
     * - the relative path from the root to the local package
     *
     * @param string[] $packageNames
     * @return mixed[]
     */
    public function decoratePackageComposerJsonWithPackageSymlinks(\MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileInfo $packageFileInfo, array $packageNames, \MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileInfo $mainComposerJsonFileInfo, bool $symlink) : array
    {
        $relativePathFromTargetPackageToRoot = $this->packagePathResolver->resolveRelativeFolderPathToLocalPackage($mainComposerJsonFileInfo, $packageFileInfo);
        $packageComposerJson = $this->jsonFileManager->loadFromFileInfo($packageFileInfo);
        // @see https://getcomposer.org/doc/05-repositories.md#path
        foreach ($packageNames as $packageName) {
            $usedPackageFileInfo = $this->composerJsonProvider->getPackageFileInfoByName($packageName);
            $relativeDirectoryFromRootToLocalPackage = $this->packagePathResolver->resolveRelativeDirectoryToRoot($mainComposerJsonFileInfo, $usedPackageFileInfo);
            $relativePathToLocalPackage = $relativePathFromTargetPackageToRoot . $relativeDirectoryFromRootToLocalPackage;
            $repositoriesContent = [self::TYPE => 'path', self::URL => $relativePathToLocalPackage, self::OPTIONS => ['symlink' => $symlink]];
            if (\array_key_exists(\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES, $packageComposerJson)) {
                $packageComposerJson = $this->addRepositoryEntryToPackageComposerJson($packageComposerJson, $repositoriesContent);
            } else {
                $packageComposerJson[\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES][] = $repositoriesContent;
            }
        }
        return $packageComposerJson;
    }
    /**
     * @param mixed[] $packageComposerJson
     * @param mixed[] $repositoriesContent
     * @return mixed[]
     */
    private function addRepositoryEntryToPackageComposerJson(array $packageComposerJson, array $repositoriesContent) : array
    {
        // First check if this entry already exists and, if so, replace it
        foreach ($packageComposerJson[\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES] as $key => $repository) {
            if ($this->isSamePackageEntry($repository, $repositoriesContent)) {
                // Just override the "options"
                if (isset($repositoriesContent[self::OPTIONS])) {
                    $packageComposerJson[\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES][$key][self::OPTIONS] = $repositoriesContent[self::OPTIONS];
                } else {
                    unset($packageComposerJson[\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES][$key][self::OPTIONS]);
                }
                return $packageComposerJson;
            }
        }
        // Add the new entry
        \array_unshift($packageComposerJson[\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection::REPOSITORIES], $repositoriesContent);
        return $packageComposerJson;
    }
    /**
     * @param mixed[] $repository
     * @param mixed[] $repositoriesContent
     */
    private function isSamePackageEntry(array $repository, array $repositoriesContent) : bool
    {
        if (!isset($repository[self::TYPE])) {
            return \false;
        }
        if ($repository[self::TYPE] !== $repositoriesContent[self::TYPE]) {
            return \false;
        }
        if (!isset($repository[self::URL])) {
            return \false;
        }
        return $repository[self::URL] === $repositoriesContent[self::URL];
    }
}

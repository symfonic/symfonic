<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Package;

use MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileInfo;
final class PackageNamesProvider
{
    /**
     * @var string[]
     */
    private $names = [];
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider $composerJsonProvider, \MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->jsonFileManager = $jsonFileManager;
    }
    /**
     * @return string[]
     */
    public function provide() : array
    {
        if ($this->names !== []) {
            return $this->names;
        }
        $packagesFileInfos = $this->composerJsonProvider->getPackagesComposerFileInfos();
        foreach ($packagesFileInfos as $packagesFileInfo) {
            $name = $this->extractNameFromFileInfo($packagesFileInfo);
            if ($name !== null) {
                $this->names[] = $name;
            }
        }
        return $this->names;
    }
    private function extractNameFromFileInfo(\MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : ?string
    {
        $json = $this->jsonFileManager->loadFromFileInfo($smartFileInfo);
        return $json['name'] ?? null;
    }
}

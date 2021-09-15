<?php

declare (strict_types=1);
namespace MonorepoBuilder20210913\Symplify\SmartFileSystem\Json;

use MonorepoBuilder20210913\Nette\Utils\Arrays;
use MonorepoBuilder20210913\Nette\Utils\Json;
use MonorepoBuilder20210913\Symplify\SmartFileSystem\FileSystemGuard;
use MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @see \Symplify\SmartFileSystem\Tests\Json\JsonFileSystem\JsonFileSystemTest
 */
final class JsonFileSystem
{
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\MonorepoBuilder20210913\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \MonorepoBuilder20210913\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return mixed[]
     */
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \MonorepoBuilder20210913\Nette\Utils\Json::decode($fileContent, \MonorepoBuilder20210913\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param array<string, mixed> $jsonArray
     */
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \MonorepoBuilder20210913\Nette\Utils\Json::encode($jsonArray, \MonorepoBuilder20210913\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    /**
     * @param array<string, mixed> $newJsonArray
     */
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \MonorepoBuilder20210913\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}

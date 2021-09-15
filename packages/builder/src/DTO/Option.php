<?php

namespace Symfonic\Builder\DTO;

use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;

class Option
{
    private string $service;

    private string $commandInput;

    private string $className;

    private string $filename;

    /**
     * @return string
     */
    public function getCommandInput(): string
    {
        return $this->commandInput;
    }

    /**
     * @param string $commandInput
     */
    public function setCommandInput(string $commandInput): void
    {
        $this->commandInput = $commandInput;
        $this->setClassName($commandInput);
        $this->setFilename($commandInput);
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    private ComposerJson $composerJson;

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return ComposerJson
     */
    public function getComposerJson(): ComposerJson
    {
        return $this->composerJson;
    }

    /**
     * @param ComposerJson $composerJson
     */
    public function setComposerJson(ComposerJson $composerJson): void
    {
        $this->composerJson = $composerJson;
    }
}

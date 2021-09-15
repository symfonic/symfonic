<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Propagate;

use MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
final class VersionPropagator
{
    public function propagate(\MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $mainComposerJson, \MonorepoBuilder20210913\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $otherComposerJson) : void
    {
        $packagesToVersions = \array_merge($mainComposerJson->getRequire(), $mainComposerJson->getRequireDev());
        foreach ($packagesToVersions as $packageName => $packageVersion) {
            if (!$otherComposerJson->hasPackage($packageName)) {
                continue;
            }
            $otherComposerJson->changePackageVersion($packageName, $packageVersion);
        }
    }
}

<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\ValueObjectFactory;

use PharIo\Version\Version;
final class VersionFactory
{
    public function create(string $version) : \PharIo\Version\Version
    {
        return new \PharIo\Version\Version($version);
    }
}

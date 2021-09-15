<?php

declare (strict_types=1);
namespace Symplify\MonorepoBuilder\Json;

use Symplify\MonorepoBuilder\Package\PackageProvider;
final class PackageJsonProvider
{
    /**
     * @var \Symplify\MonorepoBuilder\Package\PackageProvider
     */
    private $packageProvider;
    public function __construct(\Symplify\MonorepoBuilder\Package\PackageProvider $packageProvider)
    {
        $this->packageProvider = $packageProvider;
    }
    /**
     * @return string[]
     */
    public function providePackages() : array
    {
        $packageShortNames = [];
        foreach ($this->packageProvider->provide() as $package) {
            $packageShortNames[] = $package->getShortName();
        }
        return $packageShortNames;
    }
    /**
     * @return string[]
     */
    public function providePackagesWithTests() : array
    {
        $packageShortNames = [];
        foreach ($this->packageProvider->provide() as $package) {
            if (!$package->hasTests()) {
                continue;
            }
            $packageShortNames[] = $package->getShortName();
        }
        return $packageShortNames;
    }
}

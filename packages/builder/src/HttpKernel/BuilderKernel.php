<?php
declare (strict_types=1);

namespace Symfonic\Builder\HttpKernel;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symplify\PhpConfigPrinter\Bundle\PhpConfigPrinterBundle;
use Symplify\SymplifyKernel\Bundle\SymplifyKernelBundle;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
use function dump;

final class BuilderKernel extends AbstractSymplifyKernel
{
    /**
     * @param LoaderInterface $loader
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
    /**
     * @return BundleInterface[]
     */
    #[Pure]
    public function registerBundles() : iterable
    {
        return [new SymplifyKernelBundle(), new PhpConfigPrinterBundle()];
    }
}

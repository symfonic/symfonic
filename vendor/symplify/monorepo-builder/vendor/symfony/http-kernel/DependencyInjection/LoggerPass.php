<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder20210913\Symfony\Component\HttpKernel\DependencyInjection;

use MonorepoBuilder20210913\Psr\Log\LoggerInterface;
use MonorepoBuilder20210913\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use MonorepoBuilder20210913\Symfony\Component\DependencyInjection\ContainerBuilder;
use MonorepoBuilder20210913\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \MonorepoBuilder20210913\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process($container)
    {
        $container->setAlias(\MonorepoBuilder20210913\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \MonorepoBuilder20210913\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}

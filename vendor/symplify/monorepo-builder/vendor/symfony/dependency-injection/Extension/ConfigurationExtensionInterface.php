<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder20210913\Symfony\Component\DependencyInjection\Extension;

use MonorepoBuilder20210913\Symfony\Component\Config\Definition\ConfigurationInterface;
use MonorepoBuilder20210913\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * ConfigurationExtensionInterface is the interface implemented by container extension classes.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
interface ConfigurationExtensionInterface
{
    /**
     * Returns extension configuration.
     *
     * @return ConfigurationInterface|null The configuration or null
     * @param mixed[] $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function getConfiguration($config, $container);
}
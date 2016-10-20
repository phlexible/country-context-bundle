<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Country context extension.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleCountryContextExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('doctrine.yml');

        $configuration = $this->getConfiguration($config, $container);
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('phlexible_country_context.countries', $config['countries']);
        $container->setParameter('phlexible_country_context.default_country', $config['default_country']);

        $container->setAlias('phlexible_country_context.country_context_manager', 'phlexible_country_context.doctrine.country_context_manager');

        $container->setAlias('phlexible_tree.node_url_generator', 'phlexible_country_context.node_url_generator.country_and_language');
    }
}

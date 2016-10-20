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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Country context configuration.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phlexible_country_context');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('default_country')->defaultValue('en')->end()
                ->arrayNode('countries')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('continent')->end()
                            ->scalarNode('country')->end()
                            ->arrayNode('languages')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('locale')->end()
                                        ->booleanNode('expose')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Country context configuration
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
            ->children()
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

<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Phlexible\Bundle\CountryContextBundle\DependencyInjection\PhlexibleCountryContextExtension;

/**
 * Phlexible country context extension test.
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 */
class PhlexibleCountryContextExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new PhlexibleCountryContextExtension(),
        );
    }

    public function testContainerWithDefaultConfiguration()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('phlexible_country_context.default_country', 'en');
        $this->assertContainerBuilderHasParameter('phlexible_country_context.countries', array());
        $this->assertContainerBuilderHasAlias('phlexible_country_context.country_context_manager', 'phlexible_country_context.doctrine.country_context_manager');
    }

    public function testContainerWithCustomerConfiguration()
    {
        $this->load(array(
            'default_country' => 'de',
            'countries' => array(
                'de' => array(
                    'continent' => 'eu',
                    'country' => 'de',
                    'languages' => array(
                        'de' => array(
                            'locale' => 'de',
                            'expose' => true,
                        ),
                    ),
                ),
            ),
        ));

        $this->assertContainerBuilderHasParameter('phlexible_country_context.default_country', 'de');
        $this->assertContainerBuilderHasParameter('phlexible_country_context.countries', array(
            'de' => array(
                'continent' => 'eu',
                'country' => 'de',
                'languages' => array(
                    'de' => array(
                        'locale' => 'de',
                        'expose' => true,
                    ),
                ),
            ),
        ));
        $this->assertContainerBuilderHasAlias('phlexible_country_context.country_context_manager', 'phlexible_country_context.doctrine.country_context_manager');
    }
}

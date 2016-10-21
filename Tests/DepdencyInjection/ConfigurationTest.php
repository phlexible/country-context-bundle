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

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Phlexible\Bundle\CountryContextBundle\DependencyInjection\Configuration;

/**
 * Configuration test.
 *
 * @author Stephan Wentz <swentz@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testDefaultValues()
    {
        $this->assertProcessedConfigurationEquals(
            array(
                array(),
            ),
            array(
                'default_country' => 'en',
                'countries' => array(),
            )
        );
    }

    public function testConfiguredValues()
    {
        $this->assertProcessedConfigurationEquals(
            array(
                array(
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
                ),
            ),
            array(
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
            )
        );
    }
}

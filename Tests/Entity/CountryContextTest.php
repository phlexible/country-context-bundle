<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\Entity;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;

/**
 * Country context test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryContextTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCountry()
    {
        $context = new CountryContext(123, 'de', CountryContext::MODE_POSITIVE);

        $this->assertCount(0, $context->getCountries());

        $context->addCountry('de');
        $this->assertCount(1, $context->getCountries());

        $context->addCountry('de');
        $this->assertCount(1, $context->getCountries());

        $context->addCountry('en');
        $this->assertCount(2, $context->getCountries());
    }

    public function testRemoveCountry()
    {
        $context = new CountryContext(123, 'de', CountryContext::MODE_POSITIVE);

        $this->assertCount(0, $context->getCountries());

        $context->addCountry('de');
        $this->assertCount(1, $context->getCountries());

        $context->addCountry('en');
        $this->assertCount(2, $context->getCountries());

        $context->removeCountry('en');
        $this->assertCount(1, $context->getCountries());

        $context->removeCountry('en');
        $this->assertCount(1, $context->getCountries());
    }

    public function testMatchCountryModePositive()
    {
        $context = new CountryContext(123, 'de', CountryContext::MODE_POSITIVE);
        $context->addCountry('de');

        $this->assertFalse($context->matchCountry('en'));
        $this->assertTrue($context->matchCountry('de'));
    }

    public function testMatchCountryModeNegative()
    {
        $context = new CountryContext(123, 'de', CountryContext::MODE_NEGATIVE);
        $context->addCountry('de');

        $this->assertTrue($context->matchCountry('en'));
        $this->assertFalse($context->matchCountry('de'));
    }
}

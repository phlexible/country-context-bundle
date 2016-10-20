<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\Mapping;

use Phlexible\Bundle\CountryContextBundle\Mapping\Country;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollectionFactory;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;

/**
 * Country collection factory test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryCollectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCollection()
    {
        $factory = new CountryCollectionFactory();
        $collection = $factory->createCollection(array(
            'de' => array('country' => 'de', 'continent' => 'eu', 'languages' => array()),
            'us' => array('country' => 'us', 'continent' => 'na', 'languages' => array()),
        ));

        $this->assertCount(2, $collection);
        $this->assertEquals(new CountryCollection(array(
            new Country('de', 'de', 'eu', new LanguageCollection(array())),
            new Country('us', 'us', 'na', new LanguageCollection(array())),
        )), $collection);
    }
}

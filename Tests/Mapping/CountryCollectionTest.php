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
use Phlexible\Bundle\CountryContextBundle\Mapping\Language;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;

/**
 * Country collection test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsAllCountries()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array())),
            new Country('us', 'us', 'na', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);

        $this->assertSame($countries, $collection->all());
    }

    public function testGetReturnsCountry()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);
        $country = $collection->get('de');

        $this->assertSame($countries[0], $country);
    }

    public function testGetReturnsNullOnNotFoundCountry()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);
        $country = $collection->get('us');

        $this->assertNull($country);
    }

    public function testContainsReturnsTrueOnFound()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);

        $this->assertTrue($collection->contains('de'));
    }

    public function testContainsReturnsFalseOnNotFound()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);

        $this->assertFalse($collection->contains('us'));
    }

    public function testFilterLanguageReturnsCountriesWithGivenLanguage()
    {
        $countries = array(
            new Country('de', 'de', 'de', new LanguageCollection(array(new Language('de', 'de_de', true)))),
            new Country('us', 'us', 'na', new LanguageCollection(array())),
        );

        $collection = new CountryCollection($countries);
        $filteredCollection = $collection->filterLanguage('de');

        $this->assertCount(1, $filteredCollection);
        $this->assertSame($countries[0], current($filteredCollection->all()));
    }
}

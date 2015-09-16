<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\Mapping;

use Phlexible\Bundle\CountryContextBundle\Mapping\Country;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollectionFactory;
use Phlexible\Bundle\CountryContextBundle\Mapping\Language;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;

/**
 * Language collection test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class LanguageCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsAllLanguages()
    {
        $languages = array(
            new Language('de', 'de_de', true),
            new Language('us', 'en_us', false),
        );

        $collection = new LanguageCollection($languages);

        $this->assertSame($languages, $collection->all());
    }

    public function testGetReturnsLanguages()
    {
        $languages = array(
            new Language('de', 'de_de', true),
        );

        $collection = new LanguageCollection($languages);
        $language = $collection->get('de');

        $this->assertSame($languages[0], $language);
    }

    public function testGetReturnsNullOnNotFoundLanguage()
    {
        $languages = array(
            new Language('de', 'de_de', true),
        );

        $collection = new LanguageCollection($languages);
        $language = $collection->get('us');

        $this->assertNull($language);
    }

    public function testContainsReturnsTrueOnFound()
    {
        $languages = array(
            new Language('de', 'de_de', true),
        );

        $collection = new LanguageCollection($languages);

        $this->assertTrue($collection->contains('de'));
    }

    public function testContainsReturnsFalseOnNotFound()
    {
        $languages = array(
            new Language('de', 'de_de', true),
        );

        $collection = new LanguageCollection($languages);

        $this->assertFalse($collection->contains('us'));
    }
}

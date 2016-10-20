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

use Phlexible\Bundle\CountryContextBundle\Mapping\Language;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;

/**
 * Language collection test.
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

<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\ElementBundle\Tests\Twig\Extension;

use Phlexible\Bundle\CountryContextBundle\Mapping\Country;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\Language;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;
use Phlexible\Bundle\CountryContextBundle\Twig\Extension\CountryContextExtension;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeNode;
use Phlexible\Bundle\TreeBundle\ContentTree\DelegatingContentTree;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Twig country context extension test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\Twig\Extension\CountryContextExtension
 */
class CountryContextExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testCountries()
    {
        $requestStack = new RequestStack();
        $countries = new CountryCollection(array(
            new Country('de', 'de', 'eu', new LanguageCollection(array(new Language('de', 'de', true)))),
            new Country('at', 'at', 'eu', new LanguageCollection(array(new Language('de', 'de', false)))),
            new Country('us', 'us', 'na', new LanguageCollection(array(new Language('en', 'en', false)))),
        ));
        $extension = new CountryContextExtension($requestStack, $countries);

        $result = $extension->countries();

        $this->assertCount(1, $result);
        $this->assertTrue($result->contains('de'));
    }

    public function testLanguages()
    {
        $node = new ContentTreeNode();
        $tree = $this->prophesize(DelegatingContentTree::class);
        $tree->isPublished($node, 'de')->willReturn(true);
        $tree->isPublished($node, 'en')->willReturn(true);
        $tree->isPublished($node, 'nl')->willReturn(false);
        $tree->isPublished($node, 'fr')->willReturn(true);
        $node->setTree($tree->reveal());
        $request = new Request();
        $request->attributes->set('_country', 'de');
        $request->attributes->set('contentDocument', $node);
        $requestStack = new RequestStack();
        $requestStack->push($request);
        $countries = new CountryCollection(array(
            new Country('de', 'de', 'eu', new LanguageCollection(array(new Language('de', 'de', true), new Language('en', 'en', true), new Language('nl', 'nl', true), new Language('fr', 'fr', false)))),
            new Country('at', 'at', 'eu', new LanguageCollection(array(new Language('de', 'de', true)))),
            new Country('us', 'us', 'na', new LanguageCollection(array(new Language('en', 'en', true)))),
        ));
        $extension = new CountryContextExtension($requestStack, $countries);

        $result = $extension->languages();

        $this->assertCount(2, $result);
        $this->assertTrue($result->contains('de'));
    }
}

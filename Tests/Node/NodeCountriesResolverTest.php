<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Mapping\Country;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\Language;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Node countries resolver test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeCountriesResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NodeCountriesResolver
     */
    private $countryResolver;

    /**
     * @var CountryContextManagerInterface|ObjectProphecy
     */
    private $countryContextManager;

    /**
     * @var CountryCollection
     */
    private $countries;

    public function setUp()
    {
        $this->countryContextManager = $this->prophesize('Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface');
        $this->countries = new CountryCollection(array(
            new Country('de', 'de', 'eu', new LanguageCollection(array(new Language('de', 'de', true)))),
            new Country('at', 'at', 'eu', new LanguageCollection(array(new Language('de', 'de', true)))),
            new Country('us', 'us', 'na', new LanguageCollection(array(new Language('en', 'en', true)))),
        ));

        $this->countryResolver = new NodeCountriesResolver(
            $this->countryContextManager->reveal(),
            $this->countries
        );
    }

    /**
     * {@inheritdoc}
     */
    public function testResolvePositiveCountries()
    {
        $countryContext = new CountryContext(123, 'en');
        $countryContext->setCountries(array('de', 'at'));

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $countries = $this->countryResolver->resolveCountries($node, 'de');

        $this->assertCount(2, $countries);
        $this->assertTrue($countries->contains('de'));
        $this->assertTrue($countries->contains('at'));
    }

    /**
     * {@inheritdoc}
     */
    public function testResolveNegativeCountries()
    {
        $countryContext = new CountryContext(123, 'en', 'negative');
        $countryContext->setCountries(array('de', 'at'));

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $countries = $this->countryResolver->resolveCountries($node, 'en');

        $this->assertCount(1, $countries);
        $this->assertTrue($countries->contains('us'));
    }
}

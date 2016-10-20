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
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * Node checker.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NodeChecker
     */
    private $nodeChecker;

    /**
     * @var CountryContextManagerInterface|ObjectProphecy
     */
    private $countryContextManager;

    public function setUp()
    {
        $this->countryContextManager = $this->prophesize(CountryContextManagerInterface::class);

        $this->nodeChecker = new NodeChecker($this->countryContextManager->reveal());
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsAllowedOnEmptyCountries()
    {
        $countryContext = new CountryContext(123, 'en');

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $result = $this->nodeChecker->isAllowed($node, 'de', 'de');

        $this->assertTrue($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsAllowedOnMatchingCountry()
    {
        $countryContext = new CountryContext(123, 'de');
        $countryContext->addCountry('de');

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $result = $this->nodeChecker->isAllowed($node, 'de', 'de');

        $this->assertTrue($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsNotAllowedOnMissingCountry()
    {
        $countryContext = new CountryContext(123, 'de');
        $countryContext->addCountry('us');

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $result = $this->nodeChecker->isAllowed($node, 'de', 'de');

        $this->assertFalse($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsAllowedOnMatchingNegativeCountry()
    {
        $countryContext = new CountryContext(123, 'de', 'negative');
        $countryContext->addCountry('de');

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $result = $this->nodeChecker->isAllowed($node, 'de', 'de');

        $this->assertFalse($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsNotAllowedOnMissingNegativeCountry()
    {
        $countryContext = new CountryContext(123, 'de', 'negative');
        $countryContext->addCountry('de');

        $this->countryContextManager->findOneBy(Argument::cetera())->willReturn($countryContext);

        $node = new TreeNode();
        $node->setId(123);

        $result = $this->nodeChecker->isAllowed($node, 'de', 'de');

        $this->assertFalse($result);
    }
}

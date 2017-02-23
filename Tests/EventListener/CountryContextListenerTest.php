<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\EventListener;

use ArrayObject;
use Phlexible\Bundle\CountryContextBundle\EventListener\CountryContextListener;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\CountryContextBundle\Node\NodeCheckerInterface;
use Phlexible\Bundle\ElementBundle\ElementEvents;
use Phlexible\Bundle\ElementBundle\Event\LoadDataEvent;
use Phlexible\Bundle\ElementBundle\Event\SaveNodeDataEvent;
use Phlexible\Bundle\ElementRendererBundle\Configurator\Configuration;
use Phlexible\Bundle\ElementRendererBundle\ElementRendererEvents;
use Phlexible\Bundle\ElementRendererBundle\Event\ConfigureEvent;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Symfony\Component\HttpFoundation\Request;

/**
 * Country context listener test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\EventListener\CountryContextListener
 */
class CountryContextListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertSame(
            array(
                ElementEvents::LOAD_DATA => 'onLoadElement',
                ElementEvents::SAVE_NODE_DATA => 'onSaveNodeData',
                ElementRendererEvents::CONFIGURE_TREE_NODE => 'onConfigureTreeNode',
            ),
            CountryContextListener::getSubscribedEvents()
        );
    }

    public function testOnConfigureTreeNode()
    {
        $countryContextManager = $this->prophesize(CountryContextManagerInterface::class);
        $countries = new CountryCollection(array());
        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);

        $configuration = new Configuration();
        $configuration->set('request', new Request());
        $configuration->set('treeNode', new TreeNode());
        $event = new ConfigureEvent($configuration);

        $listener = new CountryContextListener($countryContextManager->reveal(), $countries, $nodeChecker->reveal());
        $listener->onConfigureTreeNode($event);
    }

    public function testOnLoadElement()
    {
        $node = new TreeNode();

        $countryContextManager = $this->prophesize(CountryContextManagerInterface::class);
        $countries = new CountryCollection(array());
        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);

        $event = new LoadDataEvent($node, null, 'de', new ArrayObject());

        $listener = new CountryContextListener($countryContextManager->reveal(), $countries, $nodeChecker->reveal());
        $listener->onLoadElement($event);
    }

    public function testOnSaveNodeData()
    {
        $node = new TreeNode();
        $request = new Request();

        $countryContextManager = $this->prophesize(CountryContextManagerInterface::class);
        $countries = new CountryCollection(array());
        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);

        $event = new SaveNodeDataEvent($node, 'de', $request);

        $listener = new CountryContextListener($countryContextManager->reveal(), $countries, $nodeChecker->reveal());
        $listener->onSaveNodeData($event);
    }
}

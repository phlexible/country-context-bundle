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

use Phlexible\Bundle\CountryContextBundle\EventListener\CountryListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * Country listener test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\EventListener\CountryListener
 */
class CountryListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertSame(
            array(
                KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
            ),
            CountryListener::getSubscribedEvents()
        );
    }

    public function testOnKernelRequestWithSetCountry()
    {
        $request = new Request();
        $request->attributes->set('_country', 'preset');

        $kernel = $this->prophesize(Kernel::class);

        $event = new GetResponseEvent($kernel->reveal(), $request, Kernel::MASTER_REQUEST);

        $requestContext = $this->prophesize(RequestContext::class);
        $requestContext->setParameter('_country', 'preset')->shouldBeCalled();

        $router = $this->prophesize(RequestContextAwareInterface::class);
        $router->getContext()->willReturn($requestContext->reveal());

        $listener = new CountryListener($router->reveal(), 'default');
        $listener->onKernelRequest($event);

        $this->assertSame('preset', $request->attributes->get('_country'));
    }

    public function testOnKernelRequestWithDefaultCountry()
    {
        $request = new Request();

        $kernel = $this->prophesize(Kernel::class);

        $event = new GetResponseEvent($kernel->reveal(), $request, Kernel::MASTER_REQUEST);

        $requestContext = $this->prophesize(RequestContext::class);
        $requestContext->setParameter('_country', 'default')->shouldBeCalled();

        $router = $this->prophesize(RequestContextAwareInterface::class);
        $router->getContext()->willReturn($requestContext->reveal());

        $listener = new CountryListener($router->reveal(), 'default');
        $listener->onKernelRequest($event);

        $this->assertSame('default', $request->attributes->get('_country'));
    }

    public function testOnKernelRequestWithCountryFromQuery()
    {
        $request = new Request();
        $request->query->set('_country', 'foo');

        $kernel = $this->prophesize(Kernel::class);

        $event = new GetResponseEvent($kernel->reveal(), $request, Kernel::MASTER_REQUEST);

        $requestContext = $this->prophesize(RequestContext::class);
        $requestContext->setParameter('_country', 'foo')->shouldBeCalled();

        $router = $this->prophesize(RequestContextAwareInterface::class);
        $router->getContext()->willReturn($requestContext->reveal());

        $listener = new CountryListener($router->reveal(), 'default');
        $listener->onKernelRequest($event);

        $this->assertSame('foo', $request->attributes->get('_country'));
    }
}

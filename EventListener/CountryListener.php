<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * Country listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryListener implements EventSubscriberInterface
{
    /**
     * @var RequestContextAwareInterface
     */
    private $router;

    /**
     * @var string
     */
    private $defaultCountry;

    /**
     * @param RequestContextAwareInterface $router
     * @param string                       $defaultCountry
     */
    public function __construct(RequestContextAwareInterface $router, $defaultCountry)
    {
        $this->router = $router;
        $this->defaultCountry = $defaultCountry;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $this->setDefaultCountry($request);
        $this->setRouterContext($request);
    }

    /**
     * @param Request $request
     */
    private function setDefaultCountry(Request $request)
    {
        if (!$request->attributes->has('_country')) {
            if ($request->query->has('_country')) {
                $request->attributes->set('_country', $request->query->get('_country'));
            } else {
                $request->attributes->set('_country', $this->defaultCountry);
            }
        }
    }

    /**
     * @param Request $request
     */
    private function setRouterContext(Request $request)
    {
        $this->router->getContext()->setParameter('_country', $request->attributes->get('_country'));
    }
}

<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
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
    public function __construct(RequestContextAwareInterface $router, $defaultCountry = 'de')
    {
        $this->defaultCountry = $defaultCountry;
        $this->router = $router;
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
            $request->attributes->set('_country', $this->defaultCountry);
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
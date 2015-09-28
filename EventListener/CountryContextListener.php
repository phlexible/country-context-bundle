<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\EventListener;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\ElementBundle\ElementEvents;
use Phlexible\Bundle\ElementBundle\Event\LoadDataEvent;
use Phlexible\Bundle\ElementBundle\Event\SaveNodeDataEvent;
use Phlexible\Bundle\ElementRendererBundle\ElementRendererEvents;
use Phlexible\Bundle\ElementRendererBundle\Event\ConfigureEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Country context listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryContextListener implements EventSubscriberInterface
{
    /**
     * @var CountryContextManagerInterface
     */
    private $countryContxtManager;

    /**
     * @var CountryCollection
     */
    private $countries;

    /**
     * @param CountryContextManagerInterface $countryContxtManager
     * @param CountryCollection              $countries
     */
    public function __construct(CountryContextManagerInterface $countryContxtManager, CountryCollection $countries)
    {
        $this->countryContxtManager = $countryContxtManager;
        $this->countries = $countries;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ElementEvents::LOAD_DATA => 'onLoadElement',
            ElementEvents::SAVE_NODE_DATA => 'onSaveNodeData',
            ElementRendererEvents::CONFIGURE_TREE_NODE => 'onConfigureTreeNode',
        );
    }

    /**
     * @param ConfigureEvent $event
     */
    public function onConfigureTreeNode(ConfigureEvent $event)
    {
        $configuration = $event->getConfiguration();
        $request = $configuration->get('request');

        $language = $request->getLocale();
        $country = $request->attributes->get('_country');

        if (!$country) {
            return;
        }

        if (!$this->countries->contains($country)) {
            throw new NotFoundHttpException("Country $country not valid.");
        }

        $country = $this->countries->get($country);

        if (!$country->getLanguages()->contains($language)) {
            throw new NotFoundHttpException("Language $language not valid.");
        }
    }

    /**
     * @param LoadDataEvent $event
     */
    public function onLoadElement(LoadDataEvent $event)
    {
        $node = $event->getNode();
        $teaser = $event->getTeaser();
        $language = $event->getLanguage();
        $data = $event->getData();

        $countries = $this->countries->filterLanguage($language);

        $countryContext = $this->countryContxtManager->findOneBy(array(
            'nodeId' => $node->getId(),
            'language' => $language
        ));
        $mode = $countryContext->getMode();

        $contexts = array();
        foreach ($countries->all() as $country) {
            $contexts[] = array(
                'id'      => $country->getIdentifier(),
                'country' => $country->getCountry(),
                'state'   => in_array($country->getCountry(), $countryContext->getCountries()),
            );
        }

        $data->context = array(
            'mode' => $mode,
            'countries' => $contexts
        );
    }

    /**
     * @param SaveNodeDataEvent $event
     */
    public function onSaveNodeData(SaveNodeDataEvent $event)
    {
        $request = $event->getRequest();
        $node = $event->getNode();
        $language = $event->getLanguage();

        if (!$request->get('context')) {
            return;
        }

        $context = json_decode($request->get('context'), true);
        $mode = $context['mode'];

        $countryContext = $this->countryContxtManager->findOneBy(array(
            'nodeId' => $node->getId(),
            'language' => $language,
        ));
        if (!$countryContext) {
            $countryContext = new CountryContext($node->getId(), $language, $mode);
        }
        $countryContext->setMode($mode);

        $countries = array();
        foreach ($context['countries'] as $country => $state) {
            if ($state) {
                $countries[] = $country;
            }
        }

        $countryContext->setCountries($countries);

        $this->countryContxtManager->updateCountryContext($countryContext);
    }
}

<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\MappingCollection;
use Phlexible\Bundle\ElementBundle\ElementEvents;
use Phlexible\Bundle\ElementBundle\Event\LoadDataEvent;
use Phlexible\Bundle\ElementBundle\Event\SaveNodeDataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Element data listener
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class ElementDataListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CountryCollection
     */
    private $countries;

    /**
     * @param EntityManagerInterface $entityManager
     * @param CountryCollection      $countries
     */
    public function __construct(EntityManagerInterface $entityManager, CountryCollection $countries)
    {
        $this->entityManager = $entityManager;
        $this->countries = $countries;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ElementEvents::LOAD_DATA => 'onLoadElement',
            ElementEvents::SAVE_NODE_DATA => 'onSaveNodeData'
        );
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

        $countryContextRepository = $this->entityManager->getRepository('PhlexibleCountryContextBundle:CountryContext');
        $countryContexts = array();
        foreach ($countryContextRepository->findBy(array('nodeId' => $node->getId(), 'language' => $language)) as $countryContext) {
            $countryContexts[$countryContext->getCountry()] = $countryContext;
        }

        $mode = 'positive';
        $contexts = array();
        foreach ($countries->all() as $country) {
            $context = array(
                'id'      => $country->getIdentifier(),
                'country' => $country->getCountry(),
                'state'   => false,
            );
            if (isset($countryContexts[$country->getCountry()])) {
                $countryContext = $countryContexts[$country->getCountry()];
                $context['state'] = $countryContext->getState();
                $mode = $countryContext->getMode();
            }
            $contexts[] = $context;
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
        $countries = $context['countries'];

        $countryContextRepository = $this->entityManager->getRepository('PhlexibleCountryContextBundle:CountryContext');

        foreach ($countries as $country => $state) {
            $countryContext = $countryContextRepository->findOneBy(array(
                'nodeId' => $node->getId(),
                'country' => $country,
                'language' => $language,
            ));

            if (!$state) {
                if ($countryContext) {
                    $this->entityManager->remove($countryContext);
                    $this->entityManager->flush($countryContext);
                }
                continue;
            }

            if (!$countryContext) {
                $countryContext = new CountryContext();
                $countryContext
                    ->setCountry($country)
                    ->setLanguage($language)
                    ->setNodeId($node->getId())
                ;
                $this->entityManager->persist($countryContext);
            }
            $countryContext
                ->setMode($mode)
                ->setState(true);

            $this->entityManager->flush($countryContext);
        }
    }
}

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

        $contexts = array();
        foreach ($countries->all() as $mapping) {
            $contexts[] = array(
                'id'      => $mapping->getIdentifier(),
                'country' => $mapping->getCountry(),
                'state'   => isset($countryContexts[$mapping->getCountry()]) ? $countryContext->getState() : '',
            );
        }

        $data->context = $contexts;
    }

    public function onSaveNodeData(SaveNodeDataEvent $event)
    {
        $request = $event->getRequest();
        $node = $event->getNode();
        $language = $event->getLanguage();

        if (!$request->get('context')) {
            return;
        }

        $countries = json_decode($request->get('context'), true);

        $countryContextRepository = $this->entityManager->getRepository('PhlexibleCountryContextBundle:CountryContext');

        foreach ($countries as $country => $state) {
            $countryContext = $countryContextRepository->findBy(array(
                'nodeId' => $node->getId(),
                'country' => $country,
                'language' => $language,
            ));

            if ($countryContext && (!$state)) {
                $this->entityManager->remove($countryContext);
                $this->entityManager->flush($countryContext);
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
            $countryContext->setState($state);

            $this->entityManager->flush($countryContext);
        }
    }
}

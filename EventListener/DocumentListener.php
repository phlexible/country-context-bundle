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

use Phlexible\Bundle\CountryContextBundle\Node\NodeCountriesResolver;
use Phlexible\Bundle\IndexerBundle\Document\DocumentInterface;
use Phlexible\Bundle\IndexerBundle\Event\DocumentEvent;
use Phlexible\Bundle\IndexerBundle\IndexerEvents;
use Phlexible\Bundle\IndexerElementBundle\Event\MapDocumentEvent;
use Phlexible\Bundle\IndexerElementBundle\IndexerElementEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Document listener.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class DocumentListener implements EventSubscriberInterface
{
    /**
     * @var NodeCountriesResolver
     */
    private $resolver;

    /**
     * @param NodeCountriesResolver $resolver
     */
    public function __construct(NodeCountriesResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            IndexerEvents::CREATE_DOCUMENT => 'onCreateDocument',
            IndexerElementEvents::MAP_DOCUMENT => 'onMapDocument',
        );
    }

    /**
     * @param DocumentEvent $event
     */
    public function onCreateDocument(DocumentEvent $event)
    {
        $document = $event->getDocument();

        $document->setField('country', array('type' => DocumentInterface::TYPE_STRING));
    }

    /**
     * @param MapDocumentEvent $event
     */
    public function onMapDocument(MapDocumentEvent $event)
    {
        $document = $event->getDocument();
        $descriptor = $event->getDescriptor();

        $countries = array();
        foreach ($this->resolver->resolveCountries($descriptor->getNode(), $descriptor->getLanguage())->all() as $country) {
            $countries[] = $country->getCountry();
        }

        $document->set('country', $countries);
    }
}

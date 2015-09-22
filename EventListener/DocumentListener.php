<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\EventListener;

use Phlexible\Bundle\CountryContextBundle\Node\NodeCountriesResolver;
use Phlexible\Bundle\IndexerBundle\Document\DocumentInterface;
use Phlexible\Bundle\IndexerBundle\Event\DocumentEvent;
use Phlexible\Bundle\IndexerBundle\IndexerEvents;
use Phlexible\Bundle\IndexerElementBundle\Event\MapDocumentEvent;
use Phlexible\Bundle\IndexerElementBundle\IndexerElementEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * Document listener
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

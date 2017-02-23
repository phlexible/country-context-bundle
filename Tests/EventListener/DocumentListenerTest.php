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

use Phlexible\Bundle\CountryContextBundle\EventListener\DocumentListener;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Node\NodeCountriesResolver;
use Phlexible\Bundle\IndexerBundle\Event\DocumentEvent;
use Phlexible\Bundle\IndexerBundle\IndexerEvents;
use Phlexible\Bundle\IndexerPageBundle\Document\PageDocument;
use Phlexible\Bundle\IndexerPageBundle\Event\MapDocumentEvent;
use Phlexible\Bundle\IndexerPageBundle\Indexer\DocumentDescriptor;
use Phlexible\Bundle\IndexerPageBundle\IndexerPageEvents;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * Document listener test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\EventListener\DocumentListener
 */
class DocumentListenerTest extends TestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertSame(
            array(
                IndexerEvents::CREATE_DOCUMENT => 'onCreateDocument',
                IndexerPageEvents::MAP_DOCUMENT => 'onMapDocument',
            ),
            DocumentListener::getSubscribedEvents()
        );
    }

    public function testOnCreateDocument()
    {
        $document = new PageDocument();
        $event = new DocumentEvent($document);

        $resolver = $this->prophesize(NodeCountriesResolver::class);

        $listener = new DocumentListener($resolver->reveal());
        $listener->onCreateDocument($event);

        $this->assertTrue($document->hasField('country'));
    }

    public function testOnMapDocument()
    {
        $document = new PageDocument();
        $document->setField('country');

        $node = new TreeNode();

        $descriptor = $this->prophesize(DocumentDescriptor::class);
        $descriptor->getNode()->willReturn($node);
        $descriptor->getLanguage()->willReturn('de');

        $event = new MapDocumentEvent($document, $descriptor->reveal());

        $resolver = $this->prophesize(NodeCountriesResolver::class);
        $resolver->resolveCountries(Argument::cetera())->willReturn(new CountryCollection(array()));

        $listener = new DocumentListener($resolver->reveal());
        $listener->onMapDocument($event);

        $this->assertTrue($document->has('country'));
    }
}

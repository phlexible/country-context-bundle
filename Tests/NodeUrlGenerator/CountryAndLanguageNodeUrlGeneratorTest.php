<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\NodeUrlGenerator;

use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeInterface;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeManagerInterface;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeNode;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Symfony\Component\Routing\RouterInterface;

/**
 * Country and language node url generator test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAndLanguageNodeUrlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContentTreeManagerInterface
     */
    private $treeManager;

    /**
     * @var ContentTreeInterface
     */
    private $tree;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var CountryAndLanguageNodeUrlGenerator
     */
    private $generator;

    public function setUp()
    {
        $this->treeManager = $this->prophesize(ContentTreeManagerInterface::class);
        $this->router = $this->prophesize(RouterInterface::class);
        $this->tree = $this->prophesize(ContentTreeInterface::class);

        $this->generator = new CountryAndLanguageNodeUrlGenerator(
            $this->treeManager->reveal(),
            $this->router->reveal()
        );
    }

    public function testGeneratePreviewUrl()
    {
        $node = new TreeNode();
        $node->setId(123);

        $contentNode = $this->prophesize(ContentTreeNode::class);

        $this->treeManager->findByTreeId(123)->willReturn($this->tree->reveal());
        $this->tree->get(123)->willReturn($contentNode);

        $this->router->generate($contentNode, ["_country" => "de", "_preview" => true, "_locale" => "de"], true)->willReturn('testUrl');

        $result = $this->generator->generatePreviewUrl($node, 'de');

        $this->assertSame('testUrl', $result);
    }

    public function testGenerateOnlineUrl()
    {
        $node = new TreeNode();
        $node->setId(123);

        $contentNode = $this->prophesize(ContentTreeNode::class);

        $this->treeManager->findByTreeId(123)->willReturn($this->tree->reveal());
        $this->tree->get(123)->willReturn($contentNode);

        $this->router->generate($contentNode, ["_country" => "de", "_locale" => "de"], true)->willReturn('testUrl');

        $result = $this->generator->generateOnlineUrl($node, 'de');

        $this->assertSame('testUrl', $result);
    }
}

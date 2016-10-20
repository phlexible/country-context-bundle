<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\NodeUrlGenerator;

use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeManagerInterface;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Phlexible\Bundle\TreeBundle\NodeUrlGenerator\NodeUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Country and language node url generator.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAndLanguageNodeUrlGenerator implements NodeUrlGeneratorInterface
{
    /**
     * @var ContentTreeManagerInterface
     */
    private $treeManager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param ContentTreeManagerInterface $treeManager
     * @param RouterInterface             $router
     */
    public function __construct(ContentTreeManagerInterface $treeManager, RouterInterface $router)
    {
        $this->router = $router;
        $this->treeManager = $treeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePreviewUrl(TreeNode $node, $language)
    {
        $contentNode = $this->treeManager->findByTreeId($node->getId())->get($node->getId());

        return $this->router->generate(
            $contentNode,
            array('_country' => $language, '_preview' => true, '_locale' => $language),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /**
     * {@inheritdoc}
     */
    public function generateOnlineUrl(TreeNode $node, $language)
    {
        $contentNode = $this->treeManager->findByTreeId($node->getId())->get($node->getId());

        return $this->router->generate(
            $contentNode,
            array('_country' => $language, '_locale' => $language),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}

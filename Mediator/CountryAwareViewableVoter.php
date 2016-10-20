<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Mediator;

use Phlexible\Bundle\CountryContextBundle\Node\NodeCheckerInterface;
use Phlexible\Bundle\TreeBundle\Mediator\ViewableVoter;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Country aware viewable voter
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareViewableVoter extends ViewableVoter
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var NodeCheckerInterface
     */
    private $nodeChecker;

    /**
     * @param RequestStack         $requestStack
     * @param NodeCheckerInterface $nodeChecker
     */
    public function __construct(RequestStack $requestStack, NodeCheckerInterface $nodeChecker)
    {
        $this->requestStack = $requestStack;
        $this->nodeChecker = $nodeChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function isViewable(TreeNodeInterface $node, $language)
    {
        $request = $this->requestStack->getCurrentRequest();
        $country = $request->attributes->get('_country');

        if (!$this->nodeChecker->isAllowed($node, $country, $language)) {
            return false;
        }

        return parent::isViewable($node, $language);
    }
}

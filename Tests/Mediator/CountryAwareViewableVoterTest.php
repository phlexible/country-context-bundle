<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mediator;

use Phlexible\Bundle\CountryContextBundle\Node\NodeCheckerInterface;
use Phlexible\Bundle\TreeBundle\Entity\TreeNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Country aware viewable voter
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareViewableVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * {@inheritdoc}
     */
    public function testNodeIsViewableOnAllowedNodeCheck()
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('_country', 'us');

        $requestStack->push($request);

        $node = new TreeNode();
        $node->setType('element-full');
        $node->setInNavigation(true);

        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);
        $nodeChecker->isAllowed($node, 'us', 'en')->willReturn(true);

        $voter = new CountryAwareViewableVoter($requestStack, $nodeChecker->reveal());
        $voter->disablePublishCheck();

        $result = $voter->isViewable($node, 'en');

        $this->assertTrue($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsViewableFallsBackToParent()
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('_country', 'us');

        $requestStack->push($request);

        $node = new TreeNode();

        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);
        $nodeChecker->isAllowed($node, 'us', 'en')->willReturn(true);

        $voter = new CountryAwareViewableVoter($requestStack, $nodeChecker->reveal());
        $voter->disablePublishCheck();

        $result = $voter->isViewable($node, 'en');

        $this->assertFalse($result);
    }

    /**
     * {@inheritdoc}
     */
    public function testNodeIsNotViewableOnNotAllowedNodeCheck()
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('_country', 'us');

        $requestStack->push($request);

        $node = new TreeNode();
        $node->setType('element-full');

        $nodeChecker = $this->prophesize(NodeCheckerInterface::class);
        $nodeChecker->isAllowed($node, 'us', 'en')->willReturn(false);

        $voter = new CountryAwareViewableVoter($requestStack, $nodeChecker->reveal());

        $result = $voter->isViewable($node, 'en');

        $this->assertFalse($result);
    }
}

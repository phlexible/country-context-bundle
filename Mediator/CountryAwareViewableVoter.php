<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mediator;

use Phlexible\Bundle\TreeBundle\Mediator\ViewableVoter;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Country aware viewable voter
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareViewableVoter extends ViewableVoter
{
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isViewable(TreeNodeInterface $node)
    {
        return parent::isViewable($node);
    }
}

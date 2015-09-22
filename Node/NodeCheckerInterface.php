<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node checker
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface NodeCheckerInterface
{
    /**
     * @param TreeNodeInterface $node
     * @param string            $country
     * @param string            $language
     *
     * @return bool
     */
    public function isAllowed(TreeNodeInterface $node, $country, $language);
}

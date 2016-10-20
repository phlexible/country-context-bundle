<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

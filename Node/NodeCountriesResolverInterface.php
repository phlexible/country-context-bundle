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

use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node countries resolver interface.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface NodeCountriesResolverInterface
{
    /**
     * @param TreeNodeInterface $node
     * @param string            $language
     *
     * @return CountryCollection
     */
    public function resolveCountries(TreeNodeInterface $node, $language);
}

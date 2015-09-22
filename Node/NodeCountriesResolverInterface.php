<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node countries resolver interface
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

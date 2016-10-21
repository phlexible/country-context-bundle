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

use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node checker.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeChecker implements NodeCheckerInterface
{
    /**
     * @var CountryContextManagerInterface
     */
    private $countryContextManager;

    /**
     * @var bool
     */
    private $isAllowedForUndefined;

    /**
     * @param CountryContextManagerInterface $countryContextManager
     * @param bool                           $isAllowedForUndefined
     */
    public function __construct(CountryContextManagerInterface $countryContextManager, $isAllowedForUndefined = true)
    {
        $this->countryContextManager = $countryContextManager;
        $this->isAllowedForUndefined = $isAllowedForUndefined;
    }

    /**
     * {@inheritdoc}
     */
    public function isAllowed(TreeNodeInterface $node, $country, $language)
    {
        $countryContext = $this->countryContextManager->findOneBy(array(
            'nodeId' => $node->getId(),
            'language' => $language,
        ));

        if (!$countryContext || !$countryContext->getCountries()) {
            return $this->isAllowedForUndefined;
        }

        return $countryContext->matchCountry($country);
    }
}

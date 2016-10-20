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

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
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
     * @param CountryContextManagerInterface $countryContextManager
     */
    public function __construct(CountryContextManagerInterface $countryContextManager)
    {
        $this->countryContextManager = $countryContextManager;
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

        if (!$countryContext) {
            return true;
        }

        if (!$countryContext->getCountries()) {
            return true;
        }

        $mode = $countryContext->getMode();

        if ($mode === CountryContext::MODE_POSITIVE && in_array($country, $countryContext->getCountries())) {
            return true;
        } elseif ($mode === CountryContext::MODE_NEGATIVE && !in_array($country, $countryContext->getCountries())) {
            return true;
        }

        return false;
    }
}

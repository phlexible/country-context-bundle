<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node checker
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
            'nodeId'   => $node->getId(),
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

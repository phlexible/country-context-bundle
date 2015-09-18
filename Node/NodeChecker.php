<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

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

        if ($mode === 'positive' && in_array($country, $countryContext->getCountries())) {
            return true;
        }

        if ($mode === 'negative' && !in_array($country, $countryContext->getCountries())) {
            return true;
        }

        return false;
    }
}

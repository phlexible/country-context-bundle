<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Node;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node countries resolver
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class NodeCountriesResolver implements NodeCountriesResolverInterface
{
    /**
     * @var CountryContextManagerInterface
     */
    private $countryContextManager;

    /**
     * @var CountryCollection
     */
    private $countries;

    /**
     * @param CountryContextManagerInterface $countryContextManager
     * @param CountryCollection              $countries
     */
    public function __construct(CountryContextManagerInterface $countryContextManager, CountryCollection $countries)
    {
        $this->countryContextManager = $countryContextManager;
        $this->countries = $countries;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveCountries(TreeNodeInterface $node, $language)
    {
        $countryContext = $this->countryContextManager->findOneBy(array(
            'nodeId'   => $node->getId(),
            'language' => $language,
        ));

        if (!$countryContext) {
            return $this->countries;
        }

        $mode = $countryContext->getMode();
        $countries = array();

        foreach ($this->countries->all() as $country) {
            $contained = in_array($country->getCountry(), $countryContext->getCountries());
            if ($mode === CountryContext::MODE_POSITIVE && $contained) {
                $countries[] = $country;
            } elseif ($mode === CountryContext::MODE_NEGATIVE && !$contained) {
                $countries[] = $country;
            }
        }

        return new CountryCollection($countries);
    }
}

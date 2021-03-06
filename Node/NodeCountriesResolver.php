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
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;

/**
 * Node countries resolver.
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
            'nodeId' => $node->getId(),
            'language' => $language,
        ));

        if (!$countryContext) {
            return $this->countries;
        }

        $countries = array();

        foreach ($this->countries->all() as $country) {
            if ($countryContext->matchCountry($country->getCountry())) {
                $countries[] = $country;
            }
        }

        return new CountryCollection($countries);
    }
}

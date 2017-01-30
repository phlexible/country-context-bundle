<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Indexer\ParametersGenerator;


use Phlexible\Bundle\CountryContextBundle\Mapping\Country;
use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\IndexerPageBundle\Indexer\DocumentDescriptor;
use Phlexible\Bundle\IndexerPageBundle\Indexer\ParametersGenerator\IndexerParametersGeneratorInterface;

/**
 * Tries to find a country with the document language exposed.
 *
 * @author Jens Schulze <jdschulze@brainbits.net>
 */
class CountryIndexerParametersGenerator implements IndexerParametersGeneratorInterface
{
    /**
     * @var CountryCollection
     */
    private $countryCollection;

    /**
     * @param CountryCollection $countryCollection
     */
    public function __construct(CountryCollection $countryCollection)
    {
        $this->countryCollection = $countryCollection;
    }

    /**
     * @param DocumentDescriptor $identity
     *
     * @return array
     */
    public function createParameters(DocumentDescriptor $identity)
    {
        $language   = $identity->getLanguage();
        $parameters = ['_locale' => $identity->getLanguage()];

        $country = $this->countryCollection->findBy(
            function (Country $country) use ($language) {
                return ($country->getLanguages()->contains($language));
            }
        );
        if ($country) {
            $parameters = $parameters + ['_country' => $country->getIdentifier()];
        }

        return $parameters;
    }
}

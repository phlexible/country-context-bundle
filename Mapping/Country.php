<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Mapping;

/**
 * Country.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class Country
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $continent;

    /**
     * @var string
     */
    private $country;

    /**
     * @var LanguageCollection
     */
    private $languages;

    /**
     * @param string             $identifier
     * @param string             $country
     * @param string             $continent
     * @param LanguageCollection $languages
     */
    public function __construct($identifier, $country, $continent, LanguageCollection $languages)
    {
        $this->identifier = $identifier;
        $this->country = $country;
        $this->continent = $continent;
        $this->languages = $languages;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @return LanguageCollection
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}

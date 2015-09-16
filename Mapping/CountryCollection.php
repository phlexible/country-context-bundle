<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mapping;

/**
 * Country collection
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryCollection implements \Countable
{
    /**
     * @var Country[]
     */
    private $countries;

    /**
     * @param Country[] $countries
     */
    public function __construct(array $countries)
    {
        foreach ($countries as $country) {
            $this->countries[$country->getIdentifier()] = $country;
        }
    }

    /**
     * @return Country[]
     */
    public function all()
    {
        return array_values($this->countries);
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function get($identifier)
    {
        if (!isset($this->countries[$identifier])) {
            return null;
        }

        return $this->countries[$identifier];
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    public function contains($identifier)
    {
        return isset($this->countries[$identifier]);
    }

    /**
     * @param string $language
     *
     * @return CountryCollection
     */
    public function filterLanguage($language)
    {
        $countries = array();
        foreach ($this->countries as $country) {
            if ($country->getLanguages()->contains($language)) {
                $countries[] = $country;
            }
        }

        return new self($countries);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->countries);
    }
}
<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country context.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @ORM\Entity
 * @ORM\Table(name="country_context")
 */
class CountryContext
{
    const MODE_POSITIVE = 'positive';
    const MODE_NEGATIVE = 'negative';

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="node_id", type="integer")
     */
    private $nodeId;

    /**
     * @var string
     * @ORM\Column(name="mode", type="string")
     */
    private $mode;

    /**
     * @var array
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $countries = array();

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false, options={"fixed": true})
     */
    private $language;

    /**
     * @param int    $nodeId
     * @param string $language
     * @param string $mode
     */
    public function __construct($nodeId, $language, $mode = self::MODE_POSITIVE)
    {
        $this->nodeId = $nodeId;
        $this->language = $language;
        $this->mode = $mode;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param array $countries
     *
     * @return $this
     */
    public function setCountries(array $countries)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function addCountry($country)
    {
        if (!in_array($country, $this->countries)) {
            $this->countries[] = $country;
        }

        return $this;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function removeCountry($country)
    {
        if (in_array($country, $this->countries)) {
            unset($this->countries[array_search($country, $this->countries)]);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }
}

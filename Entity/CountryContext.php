<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country context
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @ORM\Entity
 * @ORM\Table(name="country_context")
 */
class CountryContext
{
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
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false, options={"fixed": true})
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false, options={"fixed": true})
     */
    private $language;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $state = false;

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
     * @param int $nodeId
     *
     * @return $this
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

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
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = (bool) $state;

        return $this;
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

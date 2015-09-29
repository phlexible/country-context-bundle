<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mapping;

/**
 * Language
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class Language
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var bool
     */
    private $exposed;

    /**
     * @param string $identifier
     * @param string $locale
     * @param bool   $exposed
     */
    public function __construct($identifier, $locale, $exposed)
    {
        $this->identifier = $identifier;
        $this->locale = $locale;
        $this->exposed = $exposed;
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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return array
     */
    public function isExposed()
    {
        return $this->exposed;
    }
}

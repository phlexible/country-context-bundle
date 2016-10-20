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

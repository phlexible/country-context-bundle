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
use Traversable;

/**
 * Language collection
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class LanguageCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Language[]
     */
    private $languages;

    /**
     * @param Language[] $languages
     */
    public function __construct(array $languages)
    {
        foreach ($languages as $language) {
            $this->languages[$language->getIdentifier()] = $language;
        }
    }

    /**
     * @return Language[]
     */
    public function all()
    {
        return array_values($this->languages);
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function get($identifier)
    {
        if (!isset($this->languages[$identifier])) {
            return null;
        }

        return $this->languages[$identifier];
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    public function contains($identifier)
    {
        return isset($this->languages[$identifier]);
    }

    /**
     * @return self
     */
    public function filterExposed()
    {
        $languages = array();
        foreach ($this->languages as $language) {
            if ($language->isExposed()) {
                $languages[] = $language;
            }
        }

        return new self($languages);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->languages);
    }

    /**
     * @return Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->languages);
    }
}

<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mapping;

/**
 * Language collection
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class LanguageCollection implements \Countable
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
     * @return int
     */
    public function count()
    {
        return count($this->languages);
    }
}

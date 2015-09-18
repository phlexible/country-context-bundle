<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Mapping;

/**
 * Mapping collection factory
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryCollectionFactory
{
    /**
     * @param array $data
     *
     * @return CountryCollection
     */
    public static function createCollection(array $data)
    {
        $countries = array();
        foreach ($data as $countryIdentifier => $countryItem) {
            $languages = array();
            foreach ($countryItem['languages'] as $languageIdentifier => $languageItem) {
                $languages[] = new Language($languageIdentifier, $languageItem['locale'], $languageItem['expose']);
            }

            $countries[] = new Country($countryIdentifier, $countryItem['country'], $countryItem['continent'], new LanguageCollection($languages));
        }

        return new CountryCollection($countries);
    }
}

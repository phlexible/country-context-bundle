<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Twig\Extension;

use Phlexible\Bundle\CountryContextBundle\Mapping\CountryCollection;
use Phlexible\Bundle\CountryContextBundle\Mapping\LanguageCollection;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Twig country context extension
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryContextExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var CountryCollection
     */
    private $countryCollection;

    /**
     * @param RequestStack      $requestStack
     * @param CountryCollection $countryCollection
     */
    public function __construct(RequestStack $requestStack, CountryCollection $countryCollection)
    {
        $this->requestStack = $requestStack;
        $this->countryCollection = $countryCollection;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('countries', [$this, 'countries']),
            new \Twig_SimpleFunction('languages', [$this, 'languages']),
        ];
    }

    /**
     * @return CountryCollection
     */
    public function countries()
    {
        return $this->countryCollection->filterExposed();
    }

    /**
     * @return LanguageCollection
     */
    public function languages()
    {
        //$language = $this->requestStack->getCurrentRequest()->getLocale();
        $node = $this->requestStack->getCurrentRequest()->attributes->get('contentDocument');
        $country = $this->requestStack->getCurrentRequest()->attributes->get('_country');

        $country = $this->countryCollection->get($country);

        $languages = array();
        foreach ($country->getLanguages()->all() as $language) {
            if ($language->isExposed() && $node->getTree()->isPublished($node, $language->getLocale())) {
                $languages[] = $language;
            }
        }

        return new LanguageCollection($languages);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'phlexible_country_context';
    }
}

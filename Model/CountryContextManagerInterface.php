<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Model;

use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;

/**
 * Country context manager interface
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
interface CountryContextManagerInterface
{
    /**
     * @param int $id
     *
     * @return CountryContext
     */
    public function find($id);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $offset
     * @param int|null   $limit
     *
     * @return CountryContext[]
     */
    public function findBy(array $criteria = array(), array $orderBy = null, $offset = null, $limit = null);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return CountryContext
     */
    public function findOneBy(array $criteria = array(), array $orderBy = null);

    /**
     * @param CountryContext $countryContext
     */
    public function updateCountryContext(CountryContext $countryContext);

    /**
     * @param CountryContext $countryContext
     */
    public function deleteCountryContext(CountryContext $countryContext);
}

<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;
use Phlexible\Bundle\CountryContextBundle\Model\CountryContextManagerInterface;

/**
 * Country context manager.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryContextManager implements CountryContextManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $countryContextRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityRepository
     */
    private function getCountryContextRepository()
    {
        if ($this->countryContextRepository === null) {
            $this->countryContextRepository = $this->entityManager->getRepository(CountryContext::class);
        }

        return $this->countryContextRepository;
    }

    /**
     * @param int $id
     *
     * @return CountryContext
     */
    public function find($id)
    {
        return $this->getCountryContextRepository()->find($id);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $offset
     * @param int|null   $limit
     *
     * @return CountryContext[]
     */
    public function findBy(array $criteria = array(), array $orderBy = null, $offset = null, $limit = null)
    {
        return $this->getCountryContextRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return CountryContext
     */
    public function findOneBy(array $criteria = array(), array $orderBy = null)
    {
        return $this->getCountryContextRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * @param CountryContext $countryContext
     */
    public function updateCountryContext(CountryContext $countryContext)
    {
        $this->entityManager->persist($countryContext);
        $this->entityManager->flush($countryContext);
    }

    /**
     * @param CountryContext $countryContext
     */
    public function deleteCountryContext(CountryContext $countryContext)
    {
        $this->entityManager->remove($countryContext);
        $this->entityManager->flush($countryContext);
    }
}

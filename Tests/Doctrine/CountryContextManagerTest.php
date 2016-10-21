<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Tests\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Phlexible\Bundle\CountryContextBundle\Doctrine\CountryContextManager;
use Phlexible\Bundle\CountryContextBundle\Entity\CountryContext;

/**
 * Country context manager test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @covers \Phlexible\Bundle\CountryContextBundle\Doctrine\CountryContextManager
 */
class CountryContextManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->find(123)->shouldBeCalled()->willReturn(null);

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(CountryContext::class)->willReturn($repository);

        $manager = new CountryContextManager($em->reveal());
        $manager->find(123);
    }

    public function testFindBy()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findBy(array(3), array(4), 5, 6)->shouldBeCalled()->willReturn(null);

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(CountryContext::class)->willReturn($repository);

        $manager = new CountryContextManager($em->reveal());
        $manager->findBy(array(3), array(4), 5, 6);
    }

    public function testFindOneBy()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $repository->findOneBy(array(3), array(4))->shouldBeCalled()->willReturn(null);

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(CountryContext::class)->willReturn($repository);

        $manager = new CountryContextManager($em->reveal());
        $manager->findOneBy(array(3), array(4));
    }

    public function testUpdateCountryContext()
    {
        $countryContext = new CountryContext(123, 'de');

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->persist($countryContext)->shouldBeCalled();
        $em->flush($countryContext)->shouldBeCalled();

        $manager = new CountryContextManager($em->reveal());
        $manager->updateCountryContext($countryContext);
    }

    public function testRemoveCountryContext()
    {
        $countryContext = new CountryContext(123, 'de');

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->remove($countryContext)->shouldBeCalled();
        $em->flush($countryContext)->shouldBeCalled();

        $manager = new CountryContextManager($em->reveal());
        $manager->deleteCountryContext($countryContext);
    }
}

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

use Doctrine\ORM\EntityManagerInterface;
use Phlexible\Bundle\CountryContextBundle\Doctrine\CountryContextManager;

/**
 * Country context manager test.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryContextManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testIt()
    {
        $em = $this->prophesize(EntityManagerInterface::class);

        $manager = new CountryContextManager($em->reveal());
    }
}

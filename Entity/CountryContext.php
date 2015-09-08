<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country context
 *
 * @author Stephan Wentz <sw@brainbits.net>
 *
 * @ORM\Entity
 * @ORM\Table(name="country_context")
 */
class CountryContext
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="node_id", type="integer")
     */
    private $nodeId;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false, options={"fixed": true})
     */
    private $country;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false, options={"fixed": true})
     */
    private $language;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $state;

}

<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle;

use Phlexible\Bundle\CountryContextBundle\DependencyInjection\Compiler\UrlGeneratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Country context bundle.
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleCountryContextBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new UrlGeneratorPass());
    }
}

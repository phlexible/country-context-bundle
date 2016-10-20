<?php

/*
 * This file is part of the phlexible country context package.
 *
 * (c) Stephan Wentz <sw@brainbits.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phlexible\Bundle\CountryContextBundle\Router\Handler;

use Phlexible\Bundle\SiterootBundle\Entity\Url;
use Phlexible\Bundle\TreeBundle\Router\Handler\DefaultRequestMatcher;

/**
 * Country aware request matcher
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareRequestMatcher extends DefaultRequestMatcher
{
    /**
     * {@inheritdoc}
     */
    protected function matchPreviewPath($path)
    {
        if (!preg_match('#^/admin/preview/(\w\w)-(\w\w)/(\d+)$#', $path, $match)) {
            return null;
        }

        return array(
            '_preview' => true,
            'country' => $match[1],
            'language' => $match[2],
            'tid' => $match[3]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function matchSiterootPath(Url $siterootUrl, $path)
    {
        if (!strlen($path) || $path === '/') {
            return array(
                'language' => $siterootUrl->getLanguage(),
                'tid' => $siterootUrl->getTarget()
            );
        } elseif (preg_match('#^/(\w\w)-(\w\w)/.+\.(\d+)\.html#', $path, $match)) {
            return array(
                '_country' => $match[1],
                'language' => $match[2],
                'tid' => $match[3]
            );
        }

        return null;
    }
}

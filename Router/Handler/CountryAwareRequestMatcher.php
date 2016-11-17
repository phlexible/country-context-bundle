<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
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
            '_country' => $match[1],
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

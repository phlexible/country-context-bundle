<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Router\Handler;

use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;
use Phlexible\Bundle\TreeBundle\Router\Handler\DefaultUrlGenerator;

/**
 * Country aware url generator
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareUrlGenerator extends DefaultUrlGenerator
{
    /**
     * {@inheritdoc}
     */
    protected function generatePathPrefix($path, TreeNodeInterface $node, $parameters)
    {
        return '/' . $parameters['_country'] . '-' . $parameters['_locale'] . $path;
    }

    /**
     * {@inheritdoc}
     */
    protected function generateQuery($path, TreeNodeInterface $node, $parameters)
    {
        unset($parameters['_country']);

        return parent::generateQuery($path, $node, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    protected function generatePreviewPath(TreeNodeInterface $node, array $parameters)
    {
        $locale = $parameters['_locale'];
        unset($parameters['_locale']);

        $country = $parameters['_country'];
        unset($parameters['_country']);

        unset($parameters['_preview']);

        $query = '';
        if (count($parameters)) {
            $query = '?' . http_build_query($parameters);
        }

        return "/admin/preview/{$country}-{$locale}/{$node->getId()}" . $query;
    }
}

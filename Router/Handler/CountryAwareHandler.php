<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Router\Handler;

use Phlexible\Bundle\SiterootBundle\Siteroot\SiterootHostnameGenerator;
use Phlexible\Bundle\SiterootBundle\Siteroot\SiterootRequestMatcher;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeManagerInterface;
use Phlexible\Bundle\TreeBundle\Model\TreeNodeInterface;
use Phlexible\Bundle\TreeBundle\Router\Handler\DefaultHandler;
use Phlexible\Bundle\SiterootBundle\Entity\Url;
use Phlexible\Bundle\TreeBundle\ContentTree\ContentTreeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default handler
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class CountryAwareHandler extends DefaultHandler
{
    /**
     * @param LoggerInterface             $logger
     * @param ContentTreeManagerInterface $treeManager
     * @param SiterootRequestMatcher      $siterootRequestMatcher
     * @param SiterootHostnameGenerator   $siterootHostnameGenerator
     * @param string                      $languages
     * @param string                      $defaultLanguage
     */
    public function __construct(
        LoggerInterface $logger,
        ContentTreeManagerInterface $treeManager,
        SiterootRequestMatcher $siterootRequestMatcher,
        SiterootHostnameGenerator $siterootHostnameGenerator,
        $languages,
        $defaultLanguage)
    {
        parent::__construct($logger, $treeManager, $siterootRequestMatcher, $siterootHostnameGenerator, $languages, $defaultLanguage);
    }

    /**
     * {@inheritdoc}
     */
    protected function matchIdentifiers(Request $request, ContentTreeInterface $tree)
    {
        $match = [];
        $path = $request->getPathInfo();
        $country = null;
        $language = null;
        $tid = null;

        /* @var $siterootUrl Url */
        $siterootUrl = $request->attributes->get('siterootUrl');

        $attributes = [];

        if (!strlen($path) || $path === '/') {
            $language = $siterootUrl->getLanguage();
            $tid = $siterootUrl->getTarget();
        } elseif (preg_match('#^/(\w\w)-(\w\w)/(.+)\.(\d+)\.html#', $path, $match)) {
            // match found
            $country = $match[1];
            $language = $match[2];
            $tid = $match[4];
        } elseif (preg_match('#^/admin/preview/(\w\w)-(\w\w)/(\d+)$#', $path, $match)) {
            // match found
            $country = $match[1];
            $language = $match[2];
            $tid      = $match[3];
            $request->attributes->set('_preview', true);
        }

        if ($language === null) {
            $language = $this->findLanguage();
        }

        if ($language) {
            $request->setLocale($language);
            $request->attributes->set('_locale', $language);
        }

        if (!$tid) {
            return null;
        }

        $request->attributes->set('tid', $tid);

        $tree->setLanguage($language);
        $treeNode = $tree->get($tid);
        if (!$treeNode) {
            return null;
        }

        if ($country) {
            $attributes['_country'] = $country;
        }

        $attributes['_route'] = $path;
        $attributes['_route_object'] = $treeNode;
        $attributes['_content'] = $treeNode;
        $attributes['_controller'] = 'PhlexibleFrontendBundle:Online:index';

        return $attributes;
    }

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

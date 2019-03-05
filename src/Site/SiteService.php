<?php

namespace Eidosmedia\Cobalt\Site;

use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Site\Entities\ContentDescriptor;
use Eidosmedia\Cobalt\Site\Entities\Menu;
use Eidosmedia\Cobalt\Site\Entities\NodeData;
use Eidosmedia\Cobalt\Site\Entities\Page;
use Eidosmedia\Cobalt\Site\Entities\PaginatedSearchResult;
use Eidosmedia\Cobalt\Site\Entities\Sitemap;
use Eidosmedia\Cobalt\Site\Entities\UrlData;
use Stringy\StaticStringy as S;

/**
 * Site service
 * 
 * @example
 * // get Site service from Cobalt SDK <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $sdk = new CobaltSDK($discoveryUri); <br />
 * <br/>
 * // get Site Service instance <br />
 * $siteName = 'my-site.com' <br />
 * $siteService = $sdk->getSiteService($siteName); <br />
 */
class SiteService extends Service {

    private $siteName;

    /**
     * Site service constructor
     * 
     * Site service constructor depends on Cobalt SDK instance and site name
     */
    public function __construct($sdk, $siteName) {
        parent::__construct($sdk);
        $this->siteName = $siteName;
    }

    /**
     * Get a site map
     * 
     * @return Sitemap object
     */
    public function getSitemap() {
        $response = $this->getHttpClient()->get('site', '/api/site', [
            'emk.site' => $this->siteName
        ]);
        return new Sitemap($response);
    }

    /**
     * Get a node based on id
     * 
     * @param node id as string
     * @return NodeData object
     */
    public function getNode($id) {
        $response = $this->getHttpClient()->get('site', '/api/nodes/' . $id, [
            'emk.site' => $this->siteName
        ]);
        return new NodeData($response);
    }

    /**
     * Get a node based on foreign id
     * 
     * @param foreign id as string
     * @return NodeData object
     */
    public function getNodeByForeignId($foreignId) {
        $response = $this->getHttpClient()->get('site', '/api/nodes/foreignid/' . $foreignId, [
            'emk.site' => $this->siteName
        ]);
        return new NodeData($response);
    }

    /**
     * Get nodes by section node or section id or section path
     * 
     * @param section node or section id or section path
     * @param list of types as string (optional)
     * @param sort criteria as string (optional)
     * @param recursive flag as boolean (optional)
     * @param offset as int (optional)
     * @param limit as int (optional)
     * @param count as int (optional)
     * @return PaginatedResult object
     */
    public function getNodesBySection($sectionOrIdOrPath, $types = null, $sortBy = null, $recursive = null, $offset = null, $limit = null, $count = null) {
        $query = [
            'emk.site' => $this->siteName,
            'type' => $types,
            'sortBy' => $sortBy,
            'recursive' => $recursive,
            'offset' => $offset,
            'limit' => $limit,
            'count' => $count
        ];
        if ($sectionOrIdOrPath instanceof NodeData) {
            $query['sectionId'] = $sectionOrIdOrPath->getId();
        } else if (S::startsWith($sectionOrIdOrPath, '/')) {
            $query['section'] = $sectionOrIdOrPath;
        } else {
            $query['sectionId'] = $sectionOrIdOrPath;
        }
        $response = $this->getHttpClient()->get('site', '/api/nodes', $query);
        $nodes = [];
        foreach ($response['result'] as $resultItem) {
            $nodes[] = new NodeData($resultItem);
        }
        return new PaginatedResult($nodes, $response['count'], $response['offset'], $response['limit']);
    }

    /**
     * Get menus
     * 
     * @return menus as an array of Menu object
     */
    public function getMenus() {
        $response = $this->getHttpClient()->get('site', '/api/menus/', [
            'emk.site' => $this->siteName
        ]);

        $menus = [];
        foreach ($response as $menuName => $menuInstance) {
            $menus[$menuName] = new Menu($menuInstance);
        }

        return $menus;
    }

    /**
     * Get menu
     * 
     * @param menu name as string
     * @return Menu object
     */
    public function getMenu($menuName) {
        $response = $this->getHttpClient()->get('site', '/api/menus/' . $menuName, [
            'emk.site' => $this->siteName
        ]);
        return new Menu($response);
    }

    /**
     * Get page
     * 
     * @param node or node id or node path
     * @param view as string (optional)
     * @param page number as int (optional)
     * @param absolute urls as boolean (optional)
     * @param aggregators as string (optional)
     * @return Page object
     */
    public function getPage($nodeOrIdOrPath, $view = null, $pageNumber = null, $urlsAbsolute = false, $aggregators = null) {
        $query = [
            'emk.site' => $this->siteName,
            'view' => $view,
            'pageNumber' => $pageNumber,
            'urlsAbsolute' => $urlsAbsolute,
            'aggregators' => $aggregators
        ];
        if ($nodeOrIdOrPath instanceof NodeData) {
            $api = '/api/pages/' . $nodeOrIdOrPath->getId();
        } else if (S::startsWith($nodeOrIdOrPath, '/')) {
            $query['url'] = $nodeOrIdOrPath;
            $api = '/api/pages';
        } else {
            $api = '/api/pages/' . $nodeOrIdOrPath;
        }
        $response = $this->getHttpClient()->get('site', $api, $query);
        return new Page($response);
    }

    /**
     * Resolve url
     * 
     * @param url as string
     * @return content description
     */
    public function resolveUrl($url) {
        $query = [
            'emk.site' => $this->siteName,
            'url' => $url
        ];
        $response = $this->getHttpClient()->get('site', '/api/urls/resolve', $query);
        $fields = array('id', 'outputMode', 'pageNumber', 'permissionVariant');
        $data = array_combine($fields, array_slice(S::split($response, '/'), 2));
        return new ContentDescriptor($data);
    }

    /**
     * Evaluate url by node id
     * 
     * @param node id as string
     * @param url evaluator options object containing view status, format, url intent, resolution type, view, page
     * @return UrlData object
     */
    public function evalUrlByNodeId($nodeId, $evalUrlOptions) {
        $query = [
            'emk.site' => $this->siteName,
            'siteName' => $this->siteName,
            'viewStatus' => $evalUrlOptions->getViewStatus(),
            'format' => $evalUrlOptions->getFormat(),
            'urlIntent' => $evalUrlOptions->getUrlIntent(),
            'resolutionType' => $evalUrlOptions->getResolutionType(),
            'view' => $evalUrlOptions->getView(),
            'page' => $evalUrlOptions->getPage()
        ];
        $response = $this->getHttpClient()->get('site', '/api/urls/' . $nodeId, $query);
        return new UrlData($response);
    }

    /**
     * Evaluate url by foreign id
     * 
     * @param foreign id as string
     * @param url evaluator options object containing: view status, <br/>
     *                                                 format, <br/>
     *                                                 url intent, <br/>
     *                                                 resolution type, <br/>
     *                                                 view, <br/>
     *                                                 page <br/>
     * @return UrlData object
     */
    public function evalUrlByForeignId($foreignId, $evalUrlOptions) {
        $query = [
            'emk.site' => $this->siteName,
            'siteName' => $this->siteName,
            'viewStatus' => $evalUrlOptions->getViewStatus(),
            'format' => $evalUrlOptions->getFormat(),
            'urlIntent' => $evalUrlOptions->getUrlIntent(),
            'resolutionType' => $evalUrlOptions->getResolutionType(),
            'view' => $evalUrlOptions->getView(),
            'page' => $evalUrlOptions->getPage()
        ];
        $response = $this->getHttpClient()->get('site', '/api/urls/foreignid/' . $foreignId, $query);
        return new UrlData($response);
    }

    /**
     * Search on Cobalt
     * 
     * @param cql search options containing: query, <br/>
     *                                       tags families (optional), <br/>
     *                                       kinds (optional), <br/>
     *                                       base type (optional), <br/>
     *                                       type (optional), <br/>
     *                                       types (optional), <br/>
     *                                       startDate (optional), <br/>
     *                                       endDate (optional), <br/>
     *                                       limit (optional), <br/>
     *                                       offset (optional), <br/>
     *                                       sorting (optional), <br/>
     *                                       sections (optional), <br/>
     *                                       aggregators (optional) <br/>
     * @return PaginatedSearchResult object
     */
    public function search($searchOptions) {
        $query = [
            'emk.site' => $this->siteName,
            'query' => $searchOptions->getQuery(),
            'tagsFamilies' => $searchOptions->getTagsFamilies(),
            'kinds' => $searchOptions->getKinds(),
            'baseType' => $searchOptions->getBaseTypes(),
            'baseTypes' => $searchOptions->getLegacyBaseTypes(),
            'type' => $searchOptions->getTypes(),
            'types' => $searchOptions->getLegacyTypes(),
            'startDate' => $searchOptions->getStartDate(),
            'endDate' => $searchOptions->getEndDate(),
            'limit' => $searchOptions->getLimit(),
            'offset' => $searchOptions->getOffset(),
            'sorting' => $searchOptions->getSorting(),
            'section' => $searchOptions->getSections(),
            'aggregator' => $searchOptions->getAggregators()
        ];
        $response = $this->getHttpClient()->get('site', '/api/search', $query);
        $nodes = [];
        foreach ($response['result'] as $resultItem) {
            $nodes[] = new NodeData($resultItem['nodeData']);
        }
        return new PaginatedSearchResult($nodes, $response['archives'], $response['tags'],
                                         $response['tookMs'], $response['count'], $response['offset'],
                                         $response['limit']);
    }

}
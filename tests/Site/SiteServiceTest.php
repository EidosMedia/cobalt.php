<?php

namespace Eidosmedia\Tests\Cobalt\Site;

use Eidosmedia\Cobalt\CobaltSDK;
use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;
use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Site\Entities\ContentData;
use Eidosmedia\Cobalt\Site\Entities\ContentDescriptor;
use Eidosmedia\Cobalt\Site\Entities\EvalUrlOptions;
use Eidosmedia\Cobalt\Site\Entities\HierarchicalNodeData;
use Eidosmedia\Cobalt\Site\Entities\Menu;
use Eidosmedia\Cobalt\Site\Entities\NodeData;
use Eidosmedia\Cobalt\Site\Entities\Page;
use Eidosmedia\Cobalt\Site\Entities\SearchOptions;
use Eidosmedia\Cobalt\Site\Entities\SiteData;
use Eidosmedia\Cobalt\Site\Entities\Sitemap;
use Eidosmedia\Cobalt\Site\Entities\SiteNode;
use Eidosmedia\Cobalt\Site\SiteService;
use PHPUnit\Framework\TestCase;
use Stringy\StaticStringy as S;

class SiteServiceTest extends TestCase {

    private static $discoveryUri = 'http://localhost:8480/discovery';
    private static $siteName = 'test-site';
    private static $sdk;
    private static $siteService;
    private static $sitemap;
    private static $page;
    private static $rootNode;

    public function testSDKInitialization() {
        self::$sdk = new CobaltSDK(self::$discoveryUri, null, null);
        self::assertInstanceOf(CobaltSDK::class, self::$sdk);
        self::$siteService = self::$sdk->getSiteService(self::$siteName);
        self::assertInstanceOf(SiteService::class, self::$siteService);
        self::$sitemap = self::$siteService->getSitemap();
        self::assertInstanceOf(Sitemap::class, self::$sitemap);
        self::$rootNode = self::$sitemap->getRoot();
        self::assertInstanceOf(NodeData::class, self::$rootNode);
        self::$page = self::$siteService->getPage(self::$rootNode->getId());
        self::assertInstanceOf(Page::class, self::$page);
    }

    public function testSitemap() {
        self::assertInstanceOf(Sitemap::class, self::$sitemap);
        $root = self::$rootNode;
        self::assertInstanceOf(HierarchicalNodeData::class, $root);
        self::assertEquals(self::$siteName, $root->getName());
        self::assertNotNull($root->getId());
        $firstLevelSectionIds = $root->getChildrenIds();
        self::assertContainsOnly('string', $firstLevelSectionIds);
        self::assertTrue(count($firstLevelSectionIds) > 0);
        $firstSectionId = $firstLevelSectionIds[0];
        $section = self::$sitemap->getSection($firstSectionId);
        self::assertInstanceOf(HierarchicalNodeData::class, $section);
        self::assertEquals($firstSectionId, $section->getId());
        $sectionPath = $section->getSectionPath();
        self::assertInternalType('string', $sectionPath);
        $sectionByPath = self::$sitemap->getSection($sectionPath);
        self::assertEquals($firstSectionId, $sectionByPath->getId());
        self::assertNull(self::$sitemap->getSection(null));
        self::assertInternalType('array', self::$sitemap->getNodes());
    }

    public function testNodeObject() {
        $rootNodeId = self::$rootNode->getId();
        $node = self::$siteService->getNode($rootNodeId);
        self::assertInstanceOf(NodeData::class, $node);
        self::assertEquals($rootNodeId, $node->getId());
        self::assertInternalType('array', $node->getChildren());
        self::assertInternalType('array', $node->getZonesNames());
        self::assertNull($node->getZoneIds(null));
    }

    public function testNodeNotFound() {
        self::expectException(HttpClientException::class);
        self::$siteService->getNode('an-invalid-id');
    }

    public function testNodesBySectionId() {
        $sectionNode = self::$rootNode;
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $sectionNodeId = $sectionNode->getId();
        $paginatedResult = self::$siteService->getNodesBySection($sectionNodeId);
        self::assertInstanceOf(PaginatedResult::class, $paginatedResult);
        self::assertEquals(0, $paginatedResult->getOffset());
        self::assertEquals(20, $paginatedResult->getLimit());
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            self::assertInstanceOf(NodeData::class, $node);
            self::assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            self::assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testNodesBySectionPath() {
        $sectionNode = self::$rootNode;
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $paginatedResult = self::$siteService->getNodesBySection($sectionPath);
        self::assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            self::assertInstanceOf(NodeData::class, $node);
            self::assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            self::assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testNodesBySectionNode() {
        $sectionNode = self::$rootNode;
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $paginatedResult = self::$siteService->getNodesBySection($sectionNode);
        self::assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            self::assertInstanceOf(NodeData::class, $node);
            self::assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            self::assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testGetNodeByForeignId() {
        $sectionNode = self::$rootNode;
        $paginatedResult = self::$siteService->getNodesBySection($sectionNode, ['article']);
        $articleWithForeignId = $paginatedResult->getResult()[0];
        self::assertNotNull($articleWithForeignId);
        self::assertInstanceOf(NodeData::class, $articleWithForeignId);
        self::assertInternalType('string', $articleWithForeignId->getForeignId());
        self::assertEquals('article', $articleWithForeignId->getSys()->getType());
        $articleWithForeignId = $articleWithForeignId->getForeignId();
        $node = self::$siteService->getNodeByForeignId($articleWithForeignId);
        self::assertInstanceOf(NodeData::class, $node);
        self::assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
        self::assertEquals($articleWithForeignId, $node->getForeignId());
    }

    public function testGetPage() {
        self::assertInstanceOf(Page::class, self::$page);
        self::assertInstanceOf(ContentData::class, self::$page->getModel());
        self::assertInstanceOf(NodeData::class, self::$page->getModel()->getData());
        self::assertEquals(self::$rootNode->getId(), self::$page->getModel()->getData()->getId());
        self::assertInternalType('array', self::$page->getModel()->getNodes());
        self::assertInternalType('array', self::$page->getModel()->getChildren());
        self::assertInstanceOf(SiteNode::class, self::$page->getSiteNode());
        self::assertInstanceOf(SiteData::class, self::$page->getSiteData());
        // get page by node
        $page = self::$siteService->getPage(self::$page->getCurrentObject());
        self::assertInstanceOf(Page::class, $page);
        // get page by path
        $page = self::$siteService->getPage($page->getSiteNode()->getPath());
        self::assertInstanceOf(Page::class, $page);
    }

    public function testGetEmptyPage() {
        $page = new Page();
        self::assertInstanceOf(Page::class, $page);
        self::assertNull($page->getModel());
        self::assertNull($page->getSiteNode());
        self::assertNull($page->getSiteData());
        $page->setModel(new ContentData());
        self::assertInstanceOf(ContentData::class, $page->getModel());
        self::assertNull($page->getModel()->getNodes());
        self::assertNull($page->getModel()->getChildren());
        self::assertNull($page->getModel()->getNode(null));
        self::assertNull($page->getModel()->getZonesNames());
        self::assertNull($page->getModel()->getZoneNodes(null));
        $page->setSiteNode(new SiteNode());
        self::assertInstanceOf(SiteNode::class, $page->getSiteNode());
        $page->setSiteData(new SiteData());
        self::assertInstanceOf(SiteData::class, $page->getSiteData());
    }

    public function testGetMenusAndGetMenu() {
        $menus = self::$siteService->getMenus();
        self::assertTrue(count($menus) > 0);
        foreach ($menus as $menuName => $menuInstance) {
            self::assertInternalType('string', $menuName);
            self::assertInstanceOf(Menu::class, $menuInstance);
            $retrievedMenu = self::$siteService->getMenu($menuInstance->getName());
            self::assertEquals($menuInstance, $retrievedMenu);
        }
    }

    public function testEvalUrlAndResolveUrl() {
        $rootNode = self::$rootNode;
        $paginatedResult = self::$siteService->getNodesBySection($rootNode, ['article']);
        $results = $paginatedResult->getResult();
        // using url intent as HOST_RELATIVE
        // because it gives just the relative path
        // eg: /024e-0be049898e8a-e3f9d4df4b23-1000/index.html
        //
        // using resolution type as CONTENT
        // because a node might not have a static resource like an image
        $data = [
            'urlIntent' => 'HOST_RELATIVE',
            'resolutionType' => 'CONTENT'
        ];
        $evalUrlOptions = new EvalUrlOptions($data);
        foreach ($results as $result) {
            $evaluatedUrlByNodeId = self::$siteService->evalUrlByNodeId($result->getId(), $evalUrlOptions);
            self::assertNotNull($evaluatedUrlByNodeId);
            if ($result->getForeignId() != null) {
                $evaluatedUrlByForeignId = self::$siteService->evalUrlByForeignId($result->getForeignId(), $evalUrlOptions);
                self::assertEquals($evaluatedUrlByNodeId, $evaluatedUrlByForeignId);
            }
            $resolvedUrl = self::$siteService->resolveUrl($evaluatedUrlByNodeId->getUrl());
            self::assertInstanceOf(ContentDescriptor::class, $resolvedUrl);
            self::assertEquals($result->getId(), $resolvedUrl->getId());
            self::assertTrue(S::startsWith($resolvedUrl, 'content'));
        }
    }

    public function testSearch() {
        $baseType = 'article';
        $data = ['baseType' => $baseType];
        $searchOptions = new SearchOptions($data);
        $paginatedSearch = self::$siteService->search($searchOptions);
        self::assertTrue($paginatedSearch->getCount() > 0);
        $article = $paginatedSearch->getResult()[0];
        self::assertInstanceOf(NodeData::class, $article);
        self::assertEquals($baseType, $article->getSys()->getBaseType());
    }

    public function testGetSubsectionsMenu() {
        $subsections = self::$sitemap->getSubsectionsMenu();
        self::assertInternalType('array', $subsections);
        foreach ($subsections as $node) {
            self::assertInstanceOf(NodeData::class, $node);
        }
        $subsections = self::$sitemap->getSubsectionsMenu('/');
        foreach ($subsections as $node) {
            self::assertInstanceOf(NodeData::class, $node);
        }
        $subsections = self::$sitemap->getSubsectionsMenu(self::$sitemap->getRoot());
        foreach ($subsections as $node) {
            self::assertInstanceOf(NodeData::class, $node);
        }
    }

}
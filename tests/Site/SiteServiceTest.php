<?php

namespace Eidosmedia\Tests\Cobalt\Site;

use Eidosmedia\Cobalt\CobaltSDK;
use Eidosmedia\Cobalt\Commons\Exceptions\HttpClientException;
use Eidosmedia\Cobalt\Commons\PaginatedResult;
use Eidosmedia\Cobalt\Site\Entities\ContentDescriptor;
use Eidosmedia\Cobalt\Site\Entities\EvalUrlOptions;
use Eidosmedia\Cobalt\Site\Entities\HierarchicalNodeData;
use Eidosmedia\Cobalt\Site\Entities\Menu;
use Eidosmedia\Cobalt\Site\Entities\NodeData;
use Eidosmedia\Cobalt\Site\Entities\Page;
use Eidosmedia\Cobalt\Site\Entities\SearchOptions;
use Eidosmedia\Cobalt\Site\Entities\Sitemap;
use Eidosmedia\Cobalt\Site\SiteService;
use PHPUnit\Framework\TestCase;
use Stringy\StaticStringy as S;

class SiteServiceTest extends TestCase {

    private static $discoveryUri = 'http://localhost:8480/discovery';
    private static $siteName = 'test-site';
    private static $sdk;
    private static $siteService;
    private static $sitemap;

    public static function setUpBeforeClass() {
        self::$sdk = new CobaltSDK(self::$discoveryUri);
        self::$siteService = self::$sdk->getSiteService(self::$siteName);
        self::assertInstanceOf(SiteService::class, self::$siteService);
        self::$sitemap = self::$siteService->getSitemap();
        self::assertInstanceOf(Sitemap::class, self::$sitemap);
    }

    public function testSitemap() {
        $root = self::$sitemap->getRoot();
        $this->assertInstanceOf(HierarchicalNodeData::class, $root);
        $this->assertEquals(self::$siteName, $root->getName());
        $this->assertNotNull($root->getId());
        $firstLevelSectionIds = $root->getChildrenIds();
        $this->assertContainsOnly('string', $firstLevelSectionIds);
        $this->assertTrue(count($firstLevelSectionIds) > 0);
        $firstSectionId = $firstLevelSectionIds[0];
        $section = self::$sitemap->getSection($firstSectionId);
        $this->assertInstanceOf(HierarchicalNodeData::class, $section);
        $this->assertEquals($firstSectionId, $section->getId());
        $sectionPath = $section->getSectionPath();
        $this->assertInternalType('string', $sectionPath);
        $sectionByPath = self::$sitemap->getSection($sectionPath);
        $this->assertEquals($firstSectionId, $sectionByPath->getId());
    }

    public function testNode() {
        $rootNodeId = self::$sitemap->getRoot()->getId();
        $node = self::$siteService->getNode($rootNodeId);
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals($rootNodeId, $node->getId());
    }

    public function testNodeNotFound() {
        $this->expectException(HttpClientException::class);
        self::$siteService->getNode('an-invalid-id');
    }

    public function testNodesBySectionId() {
        $sectionNode = self::$sitemap->getRoot();
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $sectionNodeId = $sectionNode->getId();
        $paginatedResult = self::$siteService->getNodesBySection($sectionNodeId);
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            $this->assertInstanceOf(NodeData::class, $node);
            $this->assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            $this->assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testNodesBySectionPath() {
        $sectionNode = self::$sitemap->getRoot();
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $paginatedResult = self::$siteService->getNodesBySection($sectionPath);
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            $this->assertInstanceOf(NodeData::class, $node);
            $this->assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            $this->assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testNodesBySectionNode() {
        $sectionNode = self::$sitemap->getRoot();
        $sectionPath = $sectionNode->getPubInfo()->getSectionPath();
        $paginatedResult = self::$siteService->getNodesBySection($sectionNode);
        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $nodes = $paginatedResult->getResult();
        foreach ($nodes as $node) {
            $this->assertInstanceOf(NodeData::class, $node);
            $this->assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
            $this->assertEquals($sectionPath, $node->getPubInfo()->getSectionPath());
        }
    }

    public function testGetNodeByForeignId() {
        $sectionNode = self::$sitemap->getRoot();
        $paginatedResult = self::$siteService->getNodesBySection($sectionNode, ['article']);
        $articleWithForeignId = $paginatedResult->getResult()[0];
        $this->assertNotNull($articleWithForeignId);
        $this->assertInstanceOf(NodeData::class, $articleWithForeignId);
        $this->assertInternalType('string', $articleWithForeignId->getForeignId());
        $this->assertEquals('article', $articleWithForeignId->getSys()->getType());
        $articleWithForeignId = $articleWithForeignId->getForeignId();
        $node = self::$siteService->getNodeByForeignId($articleWithForeignId);
        $this->assertInstanceOf(NodeData::class, $node);
        $this->assertEquals(self::$siteName, $node->getPubInfo()->getSiteName());
        $this->assertEquals($articleWithForeignId, $node->getForeignId());
    }

    public function testGetPage() {
        $pageNode = self::$sitemap->getRoot();
        $page = self::$siteService->getPage($pageNode->getId());
        $this->assertInstanceOf(Page::class, $page);
        $this->assertEquals($pageNode->getId(), $page->getModel()->getData()->getId());
    }

    public function testGetMenusAndGetMenu() {
        $menus = self::$siteService->getMenus();
        $this->assertTrue(count($menus) > 0);
        foreach ($menus as $menuName => $menuInstance) {
            $this->assertInternalType('string', $menuName);
            $this->assertInstanceOf(Menu::class, $menuInstance);
            $retrievedMenu = self::$siteService->getMenu($menuInstance->getName());
            $this->assertEquals($menuInstance, $retrievedMenu);
        }
    }

    public function testEvalUrlAndResolveUrl() {
        $rootNode = self::$sitemap->getRoot();
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
            $this->assertNotNull($evaluatedUrlByNodeId);
            if ($result->getForeignId() != null) {
                $evaluatedUrlByForeignId = self::$siteService->evalUrlByForeignId($result->getForeignId(), $evalUrlOptions);
                $this->assertEquals($evaluatedUrlByNodeId, $evaluatedUrlByForeignId);
            }
            $resolvedUrl = self::$siteService->resolveUrl($evaluatedUrlByNodeId->getUrl());
            $this->assertInstanceOf(ContentDescriptor::class, $resolvedUrl);
            $this->assertEquals($result->getId(), $resolvedUrl->getId());
            $this->assertTrue(S::startsWith($resolvedUrl, 'content'));
        }
    }

    public function testSearch() {
        $baseType = 'article';
        $data = ['baseType' => $baseType];
        $searchOptions = new SearchOptions($data);
        $paginatedSearch = self::$siteService->search($searchOptions);
        $this->assertTrue($paginatedSearch->getCount() > 0);
        $article = $paginatedSearch->getResult()[0];
        $this->assertInstanceOf(NodeData::class, $article);
        $this->assertEquals($baseType, $article->getSys()->getBaseType());
    }

}
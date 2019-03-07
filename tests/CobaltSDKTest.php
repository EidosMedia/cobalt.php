<?php

namespace Eidosmedia\Tests\Cobalt;

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

    public function testSDKInitialization() {
        $sdk = new CobaltSDK(self::$discoveryUri);
        $siteService = $sdk->getSiteService(self::$siteName);
        self::assertInstanceOf(SiteService::class, $siteService);
        // load it from internal cache
        $siteService = $sdk->getSiteService(self::$siteName);
        self::assertInstanceOf(SiteService::class, $siteService);
        $sitemap = $siteService->getSitemap();
        self::assertInstanceOf(Sitemap::class, $sitemap);
    }

}

<?php

namespace Eidosmedia\Tests\Cobalt\Comments;

use Eidosmedia\Cobalt\CobaltSDK;
use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\SiteService;
use Eidosmedia\Cobalt\Directory\DirectoryService;
use Eidosmedia\Cobalt\Comments\CommentsService;

class CobaltSDKTest extends TestCase {

    private static $discoveryUri = 'http://localhost:8480/discovery';
    private static $siteName = 'test-site';
    private static $sdk;

    public function testSDKInitialization() {
        self::$sdk = new CobaltSDK(self::$discoveryUri, null, null);
        self::assertInstanceOf(CobaltSDK::class, self::$sdk);
    }

    public function testSiteService() {
        $siteService = self::$sdk->getSiteService(self::$siteName);
        // first pass, site service is not cached
        self::assertNotNull($siteService);
        self::assertInstanceOf(SiteService::class, $siteService);
        $siteService = self::$sdk->getSiteService(self::$siteName);
        // second pass, getting cached site service
        self::assertNotNull($siteService);
        self::assertInstanceOf(SiteService::class, $siteService);
    }

    public function testDirectoryService() {
        $directoryService = self::$sdk->getDirectoryService();
        // first pass, directory service is not cached
        self::assertNotNull($directoryService);
        self::assertInstanceOf(DirectoryService::class, $directoryService);
        $directoryService = self::$sdk->getDirectoryService();
        // second pass, getting cached directory service
        self::assertNotNull($directoryService);
        self::assertInstanceOf(DirectoryService::class, $directoryService);
    }

    public function testCommentsService() {
        $commentsService = self::$sdk->getCommentsService();
        // first pass, directory service is not cached
        self::assertNotNull($commentsService);
        self::assertInstanceOf(CommentsService::class, $commentsService);
        $commentsService = self::$sdk->getCommentsService();
        // second pass, getting cached directory service
        self::assertNotNull($commentsService);
        self::assertInstanceOf(CommentsService::class, $commentsService);
    }

}
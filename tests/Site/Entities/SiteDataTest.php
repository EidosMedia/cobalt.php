<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Entities\SiteData;

class SiteDataTest extends TestCase {

    public function testSiteDataObject() {
		$siteName = 'test';
		$title = 'test title';
		$description = 'description';
		$viewStatus = 'LIVE';
		$rootId = 'eb00b369-be9a-4780-b35b-8c658ea0d8c2';

		$siteData = new SiteData();
		self::assertInstanceOf(SiteData::class, $siteData);
		self::assertNull($siteData->getSiteName());
		$siteData->setSiteName($siteName);
		self::assertEquals($siteName, $siteData->getSiteName());
		self::assertNull($siteData->getViewStatus());
		$siteData->setViewStatus($viewStatus);
		self::assertEquals($viewStatus, $siteData->getViewStatus());
		self::assertNull($siteData->getRootId());
		$siteData->setRootId($rootId);
		self::assertEquals($rootId, $siteData->getRootId());
		self::assertNull($siteData->getTitle());
		$siteData->setTitle($title);
		self::assertEquals($title, $siteData->getTitle());
		self::assertNull($siteData->getDescription());
		$siteData->setDescription($description);
		self::assertEquals($description, $siteData->getDescription());
    }

}

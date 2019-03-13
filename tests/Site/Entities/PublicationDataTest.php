<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\PublicationData;
use Eidosmedia\Cobalt\Site\Entities\UrlData;
use PHPUnit\Framework\TestCase;

class PublicationDataTest extends TestCase {

    public function testPublicationDataObject() {
		$url = [
				'url' => 'http://an-url1.com',
				'type' => 'HOST_RELATIVE',
				'variant' => null
		];
		$urls = [$url, new UrlData($url)];
		$canonical = '/';
		$sectionPath = '/sports';
		$pubData = new PublicationData();
		self::assertTrue(empty($pubData->getUrls()));
		$pubData->setUrls($urls);
		self::assertEquals(new UrlData($url), $pubData->getUrls()[0]);
		self::assertNull($pubData->getCanonical());
		$pubData->setCanonical($canonical);
		self::assertEquals($canonical, $pubData->getCanonical());
		self::assertNull($pubData->getSectionPath());
		$pubData->setSectionPath($sectionPath);
		self::assertEquals($sectionPath, $pubData->getSectionPath());
    }

}

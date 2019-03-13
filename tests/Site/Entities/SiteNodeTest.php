<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Entities\SiteNode;

class SiteNodeTest extends TestCase {

    public function testSiteNodeObject() {
		$id = 'b54c3260-3307-4c8f-9b29-68451c00ef97';
		$name = 'test';
		$title = 'test title';
		$description = 'description';
		$uri = 'http://localhost:8480';
		$status = 'ACTIVE';
		$type = 'site';
		$path = '/sports';

		$siteNode = new SiteNode();
		self::assertInstanceOf(SiteNode::class, $siteNode);
		self::assertNull($siteNode->getId());
		$siteNode->setId($id);
		self::assertEquals($id, $siteNode->getId());
		self::assertNull($siteNode->getName());
		$siteNode->setName($name);
		self::assertEquals($name, $siteNode->getName());
		self::assertNull($siteNode->getTitle());
		$siteNode->setTitle($title);
		self::assertEquals($title, $siteNode->getTitle());
		self::assertNull($siteNode->getDescription());
		$siteNode->setDescription($description);
		self::assertEquals($description, $siteNode->getDescription());
		self::assertNull($siteNode->getUri());
		$siteNode->setUri($uri);
		self::assertEquals($uri, $siteNode->getUri());
		self::assertNull($siteNode->getStatus());
		$siteNode->setStatus($status);
		self::assertEquals($status, $siteNode->getStatus());
		self::assertNull($siteNode->getType());
		$siteNode->setType($type);
		self::assertEquals($type, $siteNode->getType());
		self::assertNull($siteNode->getPath());
		$siteNode->setPath($path);
		self::assertEquals($path, $siteNode->getPath());
    }

}

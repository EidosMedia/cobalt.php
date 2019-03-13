<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\NodeData;
use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Entities\PublicationData;
use Eidosmedia\Cobalt\Site\Entities\SystemData;

class NodeDataTest extends TestCase {

    public function testNodeDataObject() {
		$id = 'dfc3e883-fa08-4ba6-bfd6-cfb65b5c60d4';
		$parentId = '2bd2c61c-e722-4692-8354-bc7496d73c6c';
		$name = 'test-node';
		$title = 'node created from php sdk';
		$authors = ['Author 1', 'Author2'];
		$summary = 'A summary here';
		$description = 'A description here';
		$pictureId = '4310d20d-2364-49c1-ba1d-e3fade155550';
		$content = 'Content here';
		$pubInfo = new PublicationData();
		$sysData = new SystemData();
		$node = new NodeData();
		self::assertNull($node->getId());
		$node->setId($id);
		self::assertEquals($id, $node->getId());
		self::assertNull($node->getParentId());
		$node->setParentId($parentId);
		self::assertEquals($parentId, $node->getParentId());
		self::assertNull($node->getName());
		$node->setName($name);
		self::assertEquals($name, $node->getName());
		self::assertNull($node->getTitle());
		$node->setTitle($title);
		self::assertEquals($title, $node->getTitle());
		self::assertNull($node->getAuthors());
		$node->setAuthors($authors);
		self::assertEquals($authors, $node->getAuthors());
		self::assertNull($node->getSummary());
		$node->setSummary($summary);
		self::assertEquals($summary, $node->getSummary());
		self::assertNull($node->getDescription());
		$node->setDescription($description);
		self::assertEquals($description, $node->getDescription());
		self::assertNull($node->getPictureId());
		$node->setPictureId($pictureId);
		self::assertEquals($pictureId, $node->getPictureId());
		self::assertNull($node->getContent());
		$node->setContent($content);
		self::assertEquals($content, $node->getContent());
		self::assertNull($node->getPubInfo());
		$node->setPubInfo($pubInfo);
		self::assertEquals($pubInfo, $node->getPubInfo());
		self::assertNull($node->getSys());
		$node->setSys($sysData);
		self::assertEquals($sysData, $node->getSys());
    }

}

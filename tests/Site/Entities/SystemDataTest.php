<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\SystemData;
use PHPUnit\Framework\TestCase;

class SystemDataTest extends TestCase {

    public function testNodeDataObject() {
		$kind = 'content';
		$baseType = 'article';
		$type = 'article';
		$creationTime = '2019-02-20T07:54:00.126Z';
		$createdBy = 'admin';
		$updateTime = '2019-02-20T07:54:00.551Z';
		$updatedBy = 'admin';

		$sysData = new SystemData();
		self::assertNull($sysData->getKind());
		$sysData->setKind($kind);
		self::assertEquals($kind, $sysData->getKind());
		self::assertNull($sysData->getCreationTime());
		$sysData->setCreationTime($creationTime);
		self::assertEquals(new \DateTime($creationTime), $sysData->getCreationTime());
		self::assertNull($sysData->getUpdateTime());
		$sysData->setUpdateTime($updateTime);
		self::assertEquals(new \DateTime($updateTime), $sysData->getUpdateTime());
		self::assertNull($sysData->getBaseType());
		$sysData->setBaseType($baseType);
		self::assertEquals($baseType, $sysData->getBaseType());
		self::assertNull($sysData->getType());
		$sysData->setType($type);
		self::assertEquals($type, $sysData->getType());

    }

}

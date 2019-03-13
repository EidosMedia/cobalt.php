<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\MenuItem;
use PHPUnit\Framework\TestCase;

class MenuItemTest extends TestCase {

    public function testMenuItemObject() {
		$label = 'menu1';
		$url = "description1";
		$ref = "2019-02-20T08:02:22.383Z";
		$menuItem = new MenuItem();
		self::assertNull($menuItem->getLabel());
		$menuItem->setLabel($label);
		self::assertEquals($label, $menuItem->getLabel());
		self::assertNull($menuItem->getUrl());
		$menuItem->setUrl($url);
		self::assertEquals($url, $menuItem->getUrl());
		self::assertNull($menuItem->getRef());
		$menuItem->setRef($ref);
		self::assertEquals($ref, $menuItem->getRef());
    }

}

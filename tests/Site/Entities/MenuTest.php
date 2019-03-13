<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\Menu;
use PHPUnit\Framework\TestCase;
use Eidosmedia\Cobalt\Site\Entities\MenuItem;

class MenuTest extends TestCase {

    public function testMenuObject() {
		$name = 'menu1';
		$description = "description1";
		$creationDate = "2019-02-20T08:02:22.383Z";
		$modificationDate = "2019-02-20T08:02:22.383Z";
		$menu = new Menu();
		$menu->setName($name);
		self::assertEquals($name, $menu->getName());
		$menu->setDescription($description);
		self::assertEquals($description, $menu->getDescription());
		$menu->setCreationDate($creationDate);
		self::assertEquals($creationDate, $menu->getCreationDate());
		$menu->setModificationDate($modificationDate);
		self::assertEquals($modificationDate, $menu->getModificationDate());

		$label = 'menu label';
		$url = 'http://localhost:8480';
		$ref = '28812c01-e9c9-4840-ba8d-5b8bd783f5bb';
		$menuItem = new MenuItem();
		$menuItem->setLabel($label);
		$menuItem->setUrl($url);
		$menuItem->setRef($ref);
		// pass menu itemn as a single object
		$menu->setItems($menuItem);
		self::assertEquals($menuItem, $menu->getItems()[0]);
		// pass menu item as array (most common case)
		$menu->setItems([$menuItem]);
		self::assertEquals($menuItem, $menu->getItems()[0]);
    }

}

<?php

namespace Eidosmedia\Tests\Cobalt\Directory\Entities;

use Eidosmedia\Cobalt\Directory\Entities\SessionUserData;
use PHPUnit\Framework\TestCase;

class SessionUserDataTest extends TestCase {

    public function testSessionUserDataObject() {
        $sessioUserData = new SessionUserData();
        self::assertInstanceOf(SessionUserData::class, $sessioUserData);
        self::assertNull($sessioUserData->getUser());
        self::assertNull($sessioUserData->getSession());
    }

}
<?php

namespace Eidosmedia\Tests\Cobalt\Commons;

use Eidosmedia\Cobalt\Commons\ServiceInfo;
use PHPUnit\Framework\TestCase;

class ServiceInfoTest extends TestCase {

    public function testServiceInfoObject() {
        $serviceType = 'a-service';
        $uri = 'http://localhost:8480';
        $id = '473ce5d0-78ba-43c9-8b25-2206325715e7';
        $domain = 'a-domain';
        $zone = 'a-zone';
        $serviceInfo = new ServiceInfo($serviceType, $uri, $id, $domain, $zone);
        self::assertInstanceOf(ServiceInfo::class, $serviceInfo);
        self::assertEquals($serviceType, $serviceInfo->getType());
        self::assertEquals($uri, $serviceInfo->getUri());
        self::assertEquals($id, $serviceInfo->getId());
        self::assertEquals($domain, $serviceInfo->getDomain());
        self::assertEquals($zone, $serviceInfo->getZone());
    }

}
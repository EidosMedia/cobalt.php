<?php

namespace Eidosmedia\Tests\Cobalt\Commons;

use Eidosmedia\Cobalt\Commons\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {

    public function testRequestObject() {
        $request = new Request(null);
        self::assertInstanceOf(Request::class, $request);
        $serviceType = 'a-service';
        $request->setServiceType($serviceType);
        self::assertEquals($serviceType, $request->getServiceType());
        $domain = 'a-domain';
        $request->setDomain($domain);
        self::assertEquals($domain, $request->getDomain());
        $zone = 'a-zone';
        $request->setZone($zone);
        self::assertEquals($zone, $request->getZone());
        $httpMethod = Request::HTTP_METHOD_POST;
        $request->setHttpMethod($httpMethod);
        self::assertEquals($httpMethod, $request->getHttpMethod());
        $maxRetries = 10;
        $request->setMaxRetries($maxRetries);
        self::assertEquals($maxRetries, $request->getMaxRetries());
        $retriable = false;
        $request->setRetriable($retriable);
        self::assertEquals($retriable, $request->isRetriable());
        $retriesDelay = 120;
        $request->setRetriesDelay($retriesDelay);
        self::assertEquals($retriesDelay, $request->getRetriesDelay());
    }

}
<?php

namespace Eidosmedia\Tests\Cobalt\Commons;

use Eidosmedia\Cobalt\CobaltSDK;
use Eidosmedia\Cobalt\Commons\Exceptions\ServiceNotAvailableException;
use Eidosmedia\Cobalt\Commons\HttpClient;
use PHPUnit\Framework\TestCase;

class ExceptionsTest extends TestCase {

    public function testServiceNotAvailableException() {
        $discoveryUri = 'http://localhost:8480/discovery';
        self::expectException(ServiceNotAvailableException::class);
        $sdk = new CobaltSDK($discoveryUri, null, null);
        $httpClient = new HttpClient($sdk, $discoveryUri);
        $httpClient->get('null', 'http:://invalid.url');
    }

}
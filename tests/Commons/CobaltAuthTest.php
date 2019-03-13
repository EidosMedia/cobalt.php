<?php

namespace Eidosmedia\Tests\Cobalt\Commons;

use Eidosmedia\Cobalt\Commons\CobaltAuthorizationContext;
use Eidosmedia\Cobalt\Directory\Entities\SessionUserData;
use PHPUnit\Framework\TestCase;

class CobaltAuthTest extends TestCase {

    public function testCobaltAuthContextObject() {
        $authContext = new CobaltAuthorizationContext();
        $data = [
            'user' => [
                'type' => "USER",
                'created' => "2019-02-07T14:04:33.275Z",
                'creatorId' => "902e941c-529f-3893-8463-60d3a9ebbc22",
                'lastModifierId' => "902e941c-529f-3893-8463-60d3a9ebbc22",
                'modified' => "2019-02-07T14:04:33.275Z",
                'version' => "1.0",
                'name' => "admin",
                'alias' => "admin",
                'role' => "ADMIN",
                'status' => "ENABLED",
                'lastLogin' => "2019-03-08T10:28:07.538Z",
                'bookmarks' => [],
                'id' => "902e941c-529f-3893-8463-60d3a9ebbc22"
            ],
            'session' => [
                'created' => "2019-03-08T10:28:07.538Z",
                'creatorId' => "902e941c-529f-3893-8463-60d3a9ebbc22",
                'lastModifierId' => "902e941c-529f-3893-8463-60d3a9ebbc22",
                'modified' => "2019-03-08T10:28:07.538Z",
                'version' => "1.0",
                'ip' => "127.0.0.1",
                'lastAccess' => "2019-03-08T10:28:07.538Z",
                'rememberMe' => false,
                'userAgent' => "GuzzleHttp/6.3.3 curl/7.63.0 PHP/7.3.1",
                'id' => "c6c525e5-0260-42e5-86b1-0e9c60e72c69"
            ],
            'sessionConfigurations' =>
            [
                'cookieHttpOnly' => true,
                'cookieMaxAge' => 1200,
                'cookiePath' => "/"
            ]
        ];
        $sessionUserData = new SessionUserData($data);
        $authContext->cleanAllAuths();
        self::assertNull($authContext->getCurrAuth());
        $authContext->pushAuth($sessionUserData);
        $lastAuthContext = $authContext->getCurrAuth();
        self::assertEquals($sessionUserData, $lastAuthContext);
        $authContext->removeAuth($sessionUserData->getSession());
        self::assertNull($authContext->getCurrAuth());
    }

}
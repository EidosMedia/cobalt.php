<?php

namespace Eidosmedia\Tests\Cobalt\Directory;

use Eidosmedia\Cobalt\CobaltSDK;
use Eidosmedia\Cobalt\Directory\DirectoryService;
use Eidosmedia\Cobalt\Directory\Entities\SessionData;
use Eidosmedia\Cobalt\Directory\Entities\SessionUserData;
use Eidosmedia\Cobalt\Directory\Entities\UserData;
use PHPUnit\Framework\TestCase;

class DirectoryServiceTest extends TestCase {

    private static $discoveryUri = 'http://localhost:8480/discovery';
    private static $sdk;
    private static $directoryService;

    public static function setUpBeforeClass() {
        self::$sdk = new CobaltSDK(self::$discoveryUri, null, null);
        self::$directoryService = self::$sdk->getDirectoryService();
        self::assertInstanceOf(DirectoryService::class, self::$directoryService);
    }

    public function testLogin() {
        $sessionUserData = self::$directoryService->login('admin', 'admin');
        self::assertInstanceOf(SessionUserData::class, $sessionUserData);
        $user = $sessionUserData->getUser();
        self::assertInstanceOf(UserData::class, $user);
        $session = $sessionUserData->getSession();
        self::assertInstanceOf(SessionData::class, $session);
        self::assertNotNull($user->getId());
        self::assertEquals('USER', $user->getType());
        self::assertEquals('admin', $user->getName());
        self::assertEquals('ADMIN', $user->getRole());
        self::assertEquals('ENABLED', $user->getStatus());
        self::assertNull($user->getPassword()); // password must not be leaked
        self::assertNotNull($session->getId());
    }

    public function testLogout() {
        $sessions = self::$directoryService->logout();
        self::assertTrue(count($sessions) == 1);
        self::assertInternalType('array', $sessions);
        foreach ($sessions as $session) {
            self::assertInstanceOf(SessionData::class, $session);
            self::assertNotNull($session->getId());
        }
    }

}
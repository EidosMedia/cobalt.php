<?php

namespace Eidosmedia\Cobalt\Directory;

use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Directory\Entities\SessionData;
use Eidosmedia\Cobalt\Directory\Entities\SessionUserData;

/**
 * Directory service
 * 
 * @example
 * // get Directory service from Cobalt SDK <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $sdk = new CobaltSDK($discoveryUri); <br />
 * <br/>
 * // get Directory Service instance <br />
 * $directoryService = $sdk->getDirectoryService(); <br />
 */
class DirectoryService extends Service {

    const SERVICE_TYPE = 'directory';

    /**
     * Directory service constructor
     * 
     * Directory service constructor depends on Cobalt SDK instance, tenant and realm
     */
    public function __construct($sdk) {
        parent::__construct($sdk);
    }

    /**
     * Login
     * 
     * @param userName as string
     * @param password as string
     * @param rememberMe as a boolean string ('true' or 'false')
     * @return SessionUserData object
     */
    public function login($userName, $password, $rememberMe = 'false') {
        $query = [
            'rememberMe' => $rememberMe
        ];
        $body = json_encode(['name' => $userName, 'password' => $password]);
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/sessions/login', $query, null, $body);
        $sessionUserData = new SessionUserData($response);
        $this->getSDK()->getAuthContext()->pushAuth($sessionUserData);
        return $sessionUserData;
    }

    /**
     * Logout
     * 
     * @return SessionUserData object
     */
    public function logout() {
        $body = '{}';
        $response = $this->getHttpClient()->post(self::SERVICE_TYPE, '/sessions/logout', null, null, $body);
        $sessions = [];
        foreach($response as $session) {
            $sessions[] = new SessionData($session);
        }
        $this->getSDK()->getAuthContext()->removeAuth($sessions);
        return $sessions;
    }

}
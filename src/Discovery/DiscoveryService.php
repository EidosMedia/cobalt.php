<?php

namespace Eidosmedia\Cobalt\Discovery;

use Eidosmedia\Cobalt\Commons\Service;
use Eidosmedia\Cobalt\Commons\ServiceInfo;

/**
 * Discovery service
 * 
 * @example
 * // get service instance based on service information
 * // get Discovery service from Cobalt SDK <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $sdk = new CobaltSDK($discoveryUri); <br />
 * $directoryService = $sdk->getDiscoveryService();
 */
class DiscoveryService extends Service {

    /**
     * Directory Service constructor
     * 
     * @param Cobalt SDK object
     */
    public function __construct($sdk) {
        parent::__construct($sdk);
    }

    /**
     * Get service information
     * 
     * @param type as string
     * @param domain as string
     * @param zone as string
     * @return ServiceInfo object
     */
    public function getServiceInfo($type, $domain = null, $zone = null) {
        $response = $this->getHttpClient()->get('discovery', '/services', [
            'domain' => $domain,
            'zone' => $zone,
            'type' => $type,
            'limit' => 1
        ]);
        if ($response != null && isset($response['result']) && count($response['result']) > 0) {
            $result = $response['result'][0];
            return new ServiceInfo($result['type'], $result['uri'], $result['id'], $result['domain'], $result['zone']);
        }
        // service not found
        return null;
    }

}
<?php

namespace Eidosmedia\Cobalt;

use Eidosmedia\Cobalt\Commons\HttpClient;
use Eidosmedia\Cobalt\Discovery\DiscoveryService;
use Eidosmedia\Cobalt\Site\SiteService;

/**
 * Cobalt SDK
 * 
 * This class initialize Cobalt SDK. <br />
 * It requires a Discovery URI.<br/>
 * 
 * @example
 * // get Cobalt SDK instance <br />
 * $discoveryUri = "http://cobalt-endpoint/discovery"; <br />
 * $sdk = new CobaltSDK($discoveryUri); <br />
 */
class CobaltSDK {

    private $httpClient;
    private $siteServices = [];
    private $discoveryService;

    /**
     * Cobalt SDK constructor
     * 
     * @param discovery URI as string
     */
    public function __construct($discoveryUri) {
        $this->httpClient = new HttpClient($this, $discoveryUri);
        $this->discoveryService = new DiscoveryService($this);
    }

    /**
     * Get HTTP client instance
     * 
     * @return HTTP client object
     */
    public function getHttpClient() {
        return $this->httpClient;
    }

    /**
     * Get Discovery Service
     * 
     * @return discovery service object
     */
    public function getDiscoveryService() {
        return $this->discoveryService;
    }

    /**
     * Get Site Service
     * 
     * @param site name as string
     * @return site service object
     */
    public function getSiteService($siteName) {
        $siteService = null;
        if (isset($this->siteServices[$siteName])) {
            $siteService = $this->siteServices[$siteName];
        }
        if ($siteService == null) {
            $siteService = new SiteService($this, $siteName);
            $this->siteServices[$siteName] = $siteService;
        }
        return $siteService;
    }

}
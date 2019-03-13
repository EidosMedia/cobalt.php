<?php

namespace Eidosmedia\Cobalt;

use Eidosmedia\Cobalt\Comments\CommentsService;
use Eidosmedia\Cobalt\Commons\HttpClient;
use Eidosmedia\Cobalt\Directory\DirectoryService;
use Eidosmedia\Cobalt\Discovery\DiscoveryService;
use Eidosmedia\Cobalt\Site\SiteService;
use Eidosmedia\Cobalt\Commons\CobaltAuthorizationContext;

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

    private $realm;
    private $tenant;
    private $httpClient;
    private $authContext;
    private $discoveryService;
    private $commentsServices = [];
    private $directoryServices = [];
    private $siteServices = [];

    /**
     * Cobalt SDK constructor
     * 
     * @param discovery URI as string
     */
    public function __construct($discoveryUri, $tenant = null, $realm = null) {
        $this->tenant = $tenant;
        $this->realm = $realm;
        $this->httpClient = new HttpClient($this, $discoveryUri);
        $this->discoveryService = new DiscoveryService($this);
        $this->authContext = new CobaltAuthorizationContext();
    }

    /**
     * Get tenant
     * 
     * @return tenant as string
     */
    public function getTenant() {
        return $this->tenant;
    }

    /**
     * Get realm
     * 
     * @return realm as string
     */
    public function getRealm() {
        return $this->realm;
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
     * Get Cobalt authorization context
     * 
     * @return Cobalt authorization context
     */
    public function getAuthContext() {
        return $this->authContext;
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
        $context = 'site-' . $this->tenant . '-' . $this->realm . '-' . $siteName;
        if (isset($this->siteServices[$context])) {
            $siteService = $this->siteServices[$context];
        }
        if ($siteService == null) {
            $siteService = new SiteService($this, $siteName);
            $this->siteServices[$context] = $siteService;
        }
        return $siteService;
    }

    /**
     * Get Directory Service
     * 
     * @return directory service object
     */
    public function getDirectoryService() {
        $directoryService = null;
        $context = 'directory-' . $this->tenant . '-' . $this->realm;
        if (isset($this->directoryService[$context])) {
            $directoryService = $this->directoryServices[$context];
        }
        if ($directoryService == null) {
            $directoryService = new DirectoryService($this);
            $this->directoryServices[$context] = $directoryService;
        }
        return $directoryService;
    }

    /**
     * Get Comments Service
     * 
     * @return comments service object
     */
    public function getCommentService() {
        $commentService = null;
        $context = 'comments-' . $this->tenant . '-' . $this->realm;
        if (isset($this->commentsServices[$context])) {
            $commentService = $this->commentsServices[$context];
        }
        if ($commentService == null) {
            $commentService = new CommentsService($this);
            $this->commentsServices[$context] = $commentService;
        }
        return $commentService;
    }

}
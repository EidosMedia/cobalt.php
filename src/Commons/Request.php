<?php

namespace Eidosmedia\Cobalt\Commons;

class Request {

    const DEFAULT_MAX_RETRIES = 5;
    const DEFAULT_RETRIABLE = true;
    const DEFAULT_RETRIES_DELAY = 500;

    private $serviceType;
    private $domain;
    private $zone;
    private $httpMethod;
    private $path;
    private $queryParams;
    private $maxRetries;
    private $retriable;
    private $retriesDelay;

    public function __construct($serviceType, $httpMethod = 'GET') {
        $this->serviceType = $serviceType;
        $this->httpMethod = $httpMethod;
    }

    public function setServiceType($serviceType) {
        $this->serviceType = $serviceType;
    }

    public function getServiceType() {
        return $this->serviceType;
    }

    public function setDomain($domain) {
        $this->domain = $domain;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function setZone($zone) {
        $this->zone = $zone;
    }

    public function getZone() {
        return $this->zone;
    }

    public function setHttpMethod($httpMethod) {
        $this->httpMethod = $httpMethod;
    }

    public function getHttpMethod() {
        return $this->httpMethod;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getQueryParams(){
        return $this->queryParams;
    }

    public function setQueryParams($queryParams) {
        $this->queryParams = $queryParams;
    }

    public function getMaxRetries() {
        return $this->maxRetries || Request::DEFAULT_MAX_RETRIES;
    }

    public function setMaxRetries($maxRetries) {
        $this->maxRetries = $maxRetries;
    }

    public function isRetriable() {
        return $this->retriable || Request::DEFAULT_RETRIABLE;
    }

    public function setRetriable($retriable) {
        $this->retriable = $retriable;
    }

    public function getRetriesDelay() {
        return $this->retriesDelay || Request::DEFAULT_RETRIES_DELAY;
    }

    public function setRetriesDelay($retriesDelay) {
        $this->retriesDelay = $retriesDelay;
    }

}
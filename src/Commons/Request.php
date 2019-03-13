<?php

namespace Eidosmedia\Cobalt\Commons;

class Request {

    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';

    const DEFAULT_MAX_RETRIES = 5;
    const DEFAULT_RETRIABLE = true;
    const DEFAULT_RETRIES_DELAY = 500;

    private $serviceType;
    private $domain;
    private $zone;
    private $httpMethod;
    private $path;
    private $headerParams;
    private $queryParams;
    private $body;
    private $maxRetries;
    private $retriable;
    private $retriesDelay;

    public function __construct($serviceType, $httpMethod = self::HTTP_METHOD_GET) {
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

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function setQueryParams($queryParams) {
        $this->queryParams = $queryParams;
    }

    public function getQueryParams() {
        return $this->queryParams;
    }

    public function setHeaderParams($headerParams) {
        $this->headerParams = $headerParams;
    }

    public function getHeaderParams() {
        return $this->headerParams;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function getbody() {
        return $this->body;
    }

    public function setMaxRetries($maxRetries) {
        $this->maxRetries = $maxRetries;
    }

    public function getMaxRetries() {
        if (isset($this->maxRetries)) {
            return $this->maxRetries;
        }
        return Request::DEFAULT_MAX_RETRIES;
    }

    public function setRetriable($retriable) {
        $this->retriable = $retriable;
    }

    public function isRetriable() {
        if (isset($this->retriable) && is_bool($this->retriable)) {
            return $this->retriable;
        }
        return Request::DEFAULT_RETRIABLE;
    }

    public function setRetriesDelay($retriesDelay) {
        $this->retriesDelay = $retriesDelay;
    }

    public function getRetriesDelay() {
        if (isset($this->retriesDelay)) {
            return $this->retriesDelay;
        }
        return Request::DEFAULT_RETRIES_DELAY;
    }

}
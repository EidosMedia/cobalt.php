<?php

namespace Eidosmedia\Cobalt\Commons;

abstract class Service {

    private $sdk;

    public function __construct($sdk) {
        $this->sdk = $sdk;
    }

    /**
     * Get Cobalt SDK instance
     * 
     * @return sdk object
     */
    public function getSDK() {
        return $this->sdk;
    }

    public function getHttpClient() {
        return $this->sdk->getHttpClient();
    }

}
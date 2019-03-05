<?php

namespace Eidosmedia\Cobalt\Commons;

class ServiceInfo {

    private $type;
    private $uri;
    private $id;
    private $domain;
    private $zone;

    public function __construct($type, $uri, $id = null, $domain = null, $zone = null) {
        $this->type = $type;
        $this->uri = $uri;
        $this->id = $id;
        $this->domain = $domain;
        $this->zone = $zone;
    }

    public function getType() {
        return $this->type;
    }

    public function getUri() {
        return $this->uri;
    }

    public function getId() {
        return $this->id;
    }

    public function getDomain() {
        return $this->domain;
    }

    public function getZone() {
        return $this->zone;
    }

}
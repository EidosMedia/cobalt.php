<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SystemData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getCreationTime() {
        if (isset($this->data['creationTime'])) {
            return new \DateTime($this->data['creationTime']);
        }
        return null;
    }

    public function getUpdateTime() {
        if (isset($this->data['updateTime'])) {
            return new \DateTime($this->data['updateTime']);
        }
        return null;
    }

    public function setKind($kind) {
        $this->data['kind'] = $kind;
    }

    public function getKind() {
        if (isset($this->data['kind'])) {
            return $this->data['kind'];
        }
        return null;
    }

    public function setBaseType($baseType) {
        $this->data['baseType'] = $baseType;
    }

    public function getBaseType() {
        if (isset($this->data['baseType'])) {
            return $this->data['baseType'];
        }
        return null;
    }

    public function setType($type) {
        $this->data['type'] = $type;
    }

    public function getType() {
        if (isset($this->data['type'])) {
            return $this->data['type'];
        }
        return null;
    }

}
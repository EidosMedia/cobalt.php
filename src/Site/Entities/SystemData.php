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

}
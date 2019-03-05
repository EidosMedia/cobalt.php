<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SystemData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getCreationTime() {
        return new \DateTime($this->data['creationTime']);
    }

}
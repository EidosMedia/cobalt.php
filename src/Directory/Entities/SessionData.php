<?php

namespace Eidosmedia\Cobalt\Directory\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SessionData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
        return null;
    }

}
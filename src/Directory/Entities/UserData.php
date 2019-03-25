<?php

namespace Eidosmedia\Cobalt\Directory\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class UserData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getName() {
        if (isset($this->data['name'])) {
            return $this->data['name'];
        }
        return null;
    }

}
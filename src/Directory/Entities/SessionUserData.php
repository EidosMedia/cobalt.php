<?php

namespace Eidosmedia\Cobalt\Directory\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SessionUserData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getUser() {
        if (isset($this->data['user'])) {
            if ($this->data['user'] instanceof UserData) {
                return $this->data['user'];
            }
            return new UserData($this->data['user']);
        }
        return null;
    }

    public function getSession() {
        if (isset($this->data['session'])) {
            if ($this->data['session'] instanceof SessionData) {
                return $this->data['session'];
            }
            return new SessionData($this->data['session']);
        }
        return null;
    }

}
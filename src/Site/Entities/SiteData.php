<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SiteData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function setTitle($title) {
        $this->data['title'] = $title;
    }

    public function getTitle() {
        if (isset($this->data['title'])) {
            return $this->data['title'];
        }
        return null;
    }

}
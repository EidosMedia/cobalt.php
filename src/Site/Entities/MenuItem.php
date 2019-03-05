<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class MenuItem extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setLabel($label) {
        $this->data['label'] = $label;
    }

    public function setUrl($url) {
        $this->data['url'] = $url;
    }

    public function setRef($ref) {
        $this->data['ref'] = $ref;
    }

}
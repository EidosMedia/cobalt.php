<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class ContentDescriptor extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function __toString() {
        return 'content://' . $this->data['id'] . '/' . $this->data['outputMode'] . '/' . $this->data['pageNumber'] . '/' . $this->data['permissionVariant'];
    }

}
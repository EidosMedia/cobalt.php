<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\SiteNode;

class SiteData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getSiteName() {
        return $this->data['siteName'];
    }

    public function getViewStatus() {
        return $this->data['viewStatus'];
    }

    public function getRootId() {
        return $this->data['rootId'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getDescription() {
        return $this->data['description'];
    }

}
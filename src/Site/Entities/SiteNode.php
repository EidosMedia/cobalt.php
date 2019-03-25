<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\NodeData;

class SiteNode extends NodeData {

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

    public function setDescription($description) {
        $this->data['description'] = $description;
    }

    public function getDescription() {
        if (isset($this->data['description'])) {
            return $this->data['description'];
        }
        return null;
    }

}
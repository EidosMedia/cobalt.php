<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\NodeData;

class SiteNode extends NodeData {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->data['id'];
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getDescription() {
        if (isset($this->data['description'])) {
            return $this->data['description'];
        }
        return null;
    }

    public function getUri() {
        return $this->data['uri'];
    }

    public function getStatus() {
        return $this->data['status'];
    }

    public function getType() {
        return $this->data['type'];
    }

    public function getPath() {
        return $this->data['path'];
    }

}
<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class ContentDescriptor extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setId($id) {
        $this->data['id'] = $id;
    }

    public function getId() {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
        return null;
    }

    public function setOutputMode($outputMode) {
        $this->data['outputMode'] = $outputMode;
    }

    public function getOutputMode() {
        if (isset($this->data['outputMode'])) {
            return $this->data['outputMode'];
        }
        return null;
    }

    public function setPageNumber($pageNumber) {
        $this->data['pageNumber'] = $pageNumber;
    }

    public function getPageNumber() {
        if (isset($this->data['pageNumber'])) {
            return $this->data['pageNumber'];
        }
        return null;
    }

    public function setPermissionVariant($permissionVariant) {
        $this->data['permissionVariant'] = $permissionVariant;
    }

    public function getPermissionVariant() {
        if (isset($this->data['permissionVariant'])) {
            return $this->data['permissionVariant'];
        }
        return null;
    }

    public function __toString() {
        return 'content://' . $this->data['id'] . '/' . $this->data['outputMode'] . '/' . $this->data['pageNumber'] . '/' . $this->data['permissionVariant'];
    }

}
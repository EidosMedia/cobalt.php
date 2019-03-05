<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class EvalUrlOptions extends Entity {

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function setViewStatus($viewStatus) {
        $this->data['viewStatus'] = $viewStatus;
    }

    public function getViewStatus() {
        if (isset($this->data['viewStatus'])) {
            return $this->data['viewStatus'];
        }
        return null;
    }

    public function setFormat($format) {
        $this->data['format'] = $format;
    }

    public function getFormat() {
        if (isset($this->data['format'])) {
            return $this->data['format'];
        }
        return null;
    }

    public function setUrlIntent($urlIntent) {
        $this->data['urlIntent'] = $urlIntent;
    }

    public function getUrlIntent() {
        if (isset($this->data['urlIntent'])) {
            return $this->data['urlIntent'];
        }
        return null;
    }

    public function setResolutionType($resolutionType) {
        $this->data['resolutionType'] = $resolutionType;
    }

    public function getResolutionType() {
        if (isset($this->data['resolutionType'])) {
            return $this->data['resolutionType'];
        }
        return null;
    }

    public function setView($view) {
        $this->data['view'] = $view;
    }

    public function getView() {
        if (isset($this->data['view'])) {
            return $this->data['view'];
        }
        return null;
    }

    public function setPage($page) {
        $this->data['page'] = $page;
    }

    public function getPage() {
        if (isset($this->data['page'])) {
            return $this->data['page'];
        }
        return null;
    }

}
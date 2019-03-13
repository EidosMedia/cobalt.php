<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\ContentData;
use Eidosmedia\Cobalt\Site\Entities\SiteNode;
use Eidosmedia\Cobalt\Site\Entities\SiteData;

class Page extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getCurrentObject() {
        return $this->getModel()->getData();
    }

    public function getModel() {
        if (isset($this->data['model'])) {
            if ($this->data['model'] instanceof ContentData) {
                return $this->data['model'];
            }
            return new ContentData($this->data['model']);
        }
        return null;
    }

    public function getSiteNode() {
        if (isset($this->data['siteNode'])) {
            if ($this->data['siteNode'] instanceof SiteNode) {
                return $this->data['siteNode'];
            }
            return new SiteNode($this->data['siteNode']);
        }
        return null;
    }

    public function getSiteData() {
        if (isset($this->data['siteData'])) {
            if ($this->data['siteData'] instanceof SiteData) {
                return $this->data['siteData'];
            }
            return new SiteData($this->data['siteData']);
        }
        return null;
    }

}
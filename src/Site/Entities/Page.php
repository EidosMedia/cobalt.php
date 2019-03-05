<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\ContentData;
use Eidosmedia\Cobalt\Site\Entities\SiteNode;
use Eidosmedia\Cobalt\Site\Entities\SiteData;

class Page extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getCurrentObject() {
        return $this->getModel()->getData();
    }

    public function getModel() {
        return new ContentData($this->data['model']);
    }

    public function getSiteNode() {
        return new SiteNode($this->data['siteNode']);
    }

    public function getSiteData() {
        return new SiteData($this->data['siteData']);
    }

    public function getResourceUrl($id) {
        return $this->data['resourcesUrls'][$id];
    }

    public function getUrl($id) {
        return $this->data['nodesUrls'][$id];
    }

}
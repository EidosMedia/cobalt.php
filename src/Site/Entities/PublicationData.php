<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\UrlData;

class PublicationData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getUrls() {
        $urls = [];
        foreach ($this->data['urls'] as $url) {
            array_push($urls, new UrlData($url));
        }
        return $urls;
    }

}
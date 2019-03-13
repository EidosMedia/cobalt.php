<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\UrlData;

class PublicationData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getPublicationData() {
        return $this->data;
    }

    public function getUrls() {
        $urls = [];
        if (isset($this->data['urls'])) {
            foreach ($this->data['urls'] as $url) {
                if ($url instanceof UrlData) {
                    array_push($urls, $url);
                } else {
                    array_push($urls, new UrlData($url));
                }
            }   
        }
        return $urls;
    }

}
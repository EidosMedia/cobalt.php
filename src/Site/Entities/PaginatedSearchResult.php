<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\PaginatedResult;

class PaginatedSearchResult extends PaginatedResult {

    private $archives;
    private $tags;
    private $tookMs;

    public function __construct($result, $archives, $tags, $tookMs, $offset, $limit) {
        parent::__construct($result, $offset, $limit);
        $this->archives = $archives;
        $this->tags = $tags;
        $this->tookMs = $tookMs;
    }

    public function getArchives() {
        return $this->archives;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getTookMs() {
        return $this->tookMs;
    }

}
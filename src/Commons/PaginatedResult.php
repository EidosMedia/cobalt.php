<?php

namespace Eidosmedia\Cobalt\Commons;

class PaginatedResult {

    private $result;
    private $offset;
    private $limit;

    public function __construct($result, $offset, $limit) {
        $this->result = $result;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getResult() {
        return $this->result;
    }

    public function getCount() {
        return count($this->result);
    }

    public function getOffset() {
        return $this->offset;
    }

    public function getLimit() {
        return $this->limit;
    }

}
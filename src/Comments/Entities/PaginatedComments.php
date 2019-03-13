<?php

namespace Eidosmedia\Cobalt\Comments\Entities;

class PaginatedComments {

    private $result;
    private $utag;

    public function __construct($result, $utag) {
        $this->result = $result;
        $this->utag = $utag;
    }

    public function getResult() {
        return $this->result;
    }

    public function getCount() {
        return count($this->result);
    }

    public function getUtag() {
        return $this->utag;
    }

}
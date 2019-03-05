<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class SearchOptions extends Entity {

    public function __construct($data = []) {
        parent::__construct($data);
    }

    public function setQuery($query) {
        $this->data['query'] = $query;
    }

    public function getQuery() {
        if (isset($this->data['query'])) {
            return $this->data['query'];
        }
        return null;
    }

    public function setTagsFamilies($tagsFamilies) {
        $this->data['tagsFamilies'] = $tagsFamilies;
    }

    public function getTagsFamilies() {
        if (isset($this->data['tagsFamilies'])) {
            return $this->data['tagsFamilies'];
        }
        return null;
    }

    public function setKinds($kinds) {
        $this->data['kinds'] = $kinds;
    }
    
    public function getKinds() {
        if (isset($this->data['kinds'])) {
            return $this->data['kinds'];
        }
        return null;
    }

    public function setBaseType($baseType) {
        $this->data['baseType'] = $baseType;
    }
    
    public function getBaseType() {
        if (isset($this->data['baseType'])) {
            return $this->data['baseType'];
        }
        return null;
    }

    public function setBaseTypes($baseTypes) {
        $this->data['baseTypes'] = $baseTypes;
    }
    
    public function getBaseTypes() {
        if (isset($this->data['baseTypes'])) {
            return $this->data['baseTypes'];
        }
        return null;
    }

    public function setType($type) {
        $this->data['type'] = $type;
    }
    
    public function getType() {
        if (isset($this->data['type'])) {
            return $this->data['type'];
        }
        return null;
    }

    public function setStartDate($startDate) {
        $this->dsata['startDate'] = $startDate;
    }
    
    public function getStartDate() {
        if (isset($this->dsata['startDate'])) {
            return $this->data['startDate'];
        }
        return null;
    }

    public function setEndDate($endDate) {
        $this->data['endDate'] = $endDate;
    }
    
    public function getEndDate() {
        if (isset($this->data['endDate'])) {
            return $this->data['endDate'];
        }
        return null;
    }

    public function setLimit($limit) {
        $this->data['limit'] = $limit;
    }
    
    public function getLimit() {
        if (isset($this->data['limit'])) {
            return $this->data['limit'];
        }
        return null;
    }

    public function setOffset($offset) {
        $this->data['offset'] = $offset;
    }
    
    public function getOffset() {
        if (isset($this->data['offset'])) {
            return  $this->data['offset'];
        }
        return null;
    }

    public function setSorting($sorting) {
        $this->data['sorting'] = $sorting;
    }
    
    public function getSorting() {
        if (isset($this->data['sorting'])) {
            return $this->data['sorting'];
        }
        return null;
    }

    public function setSection($sections) {
        $this->data['section'] = $sections;
    }
    
    public function getSection() {
        if (isset($this->data['section'])) {
            return $this->data['section'];
        }
        return null;
    }

    public function setAggregator($aggregator) {
        $this->data['aggregator'] = $aggregator;
    }
    
    public function getAggregator() {
        if (isset($this->data['aggregator'])) {
            return $this->data['aggregator'];
        }
        return null;
    }

}
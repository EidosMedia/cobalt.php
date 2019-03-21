<?php

namespace Eidosmedia\Cobalt\Comments\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class PostOptions extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function setThreadId($id) {
        $this->data['id'] = $id;
    }

    public function getThreadId() {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
        return null;
    }

    public function setExternalObjectId($externalObjectId) {
        $this->data['externalObjectId'] = $externalObjectId;
    }

    public function getExternalObjectId() {
        if (isset($this->data['externalObjectId'])) {
            return $this->data['externalObjectId'];
        }
        return null;
    }

    public function setRootId($rootId) {
        $this->data['rootId'] = $rootId;
    }

    public function getRootId() {
        if (isset($this->data['rootId'])) {
            return $this->data['rootId'];
        }
        return null;
    }

    public function setParentId($parentId) {
        $this->data['parentId'] = $parentId;
    }

    public function getParentId() {
        if (isset($this->data['parentId'])) {
            return $this->data['parentId'];
        }
        return null;
    }

    public function setStatusId($statusId) {
        $this->data['statusId'] = $statusId;
    }

    public function getStatusId() {
        if (isset($this->data['statusId'])) {
            return $this->data['statusId'];
        }
        return null;
    }

    public function setOffset($offset) {
        $this->data['offset'] = $offset;
    }

    public function getOffset() {
        if (isset($this->data['offset'])) {
            return $this->data['offset'];
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

    public function setPostId($postId) {
        $this->data['postId'] = $postId;
    }

    public function getPostId() {
        if (isset($this->data['postId'])) {
            return $this->data['postId'];
        }
        return null;
    }

    public function setLastPostId($lastPostId) {
        $this->data['lastPostId'] = $lastPostId;
    }

    public function getLastPostId() {
        if (isset($this->data['lastPostId'])) {
            return $this->data['lastPostId'];
        }
        return null;
    }

    public function setUtag($utag) {
        $this->data['utag'] = $utag;
    }

    public function getUtag() {
        if (isset($this->data['utag'])) {
            return $this->data['utag'];
        }
        return null;
    }

    public function setSort($sort) {
        $this->data['sort'] = $sort;
    }

    public function getSort() {
        if (isset($this->data['sort'])) {
            return $this->data['sort'];
        }
        return null;
    }

    public function setMaxResults($maxResults) {
        $this->data['maxResults'] = $maxResults;
    }

    public function getMaxResults() {
        if (isset($this->data['maxResults'])) {
            return $this->data['maxResults'];
        }
        return 5;
    }

}

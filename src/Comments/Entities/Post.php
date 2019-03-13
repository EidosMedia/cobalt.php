<?php

namespace Eidosmedia\Cobalt\Comments\Entities;

use Eidosmedia\Cobalt\Commons\Entity;

class Post extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getPost() {
        return $this->data;
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

    public function setExternalObjectId($externalObjectId) {
        $this->data['externalObjectId'] = $externalObjectId;
    }

    public function getExternalObjectId() {
        if (isset($this->data['externalObjectId'])) {
            return $this->data['externalObjectId'];
        }
        return null;
    }

    public function setDomainExternalObjectId($domainExternalObjectId) {
        $this->data['domainExternalObjectId'] = $domainExternalObjectId;
    }

    public function getDomainExternalObjectId() {
        if (isset($this->data['domainExternalObjectId'])) {
            return $this->data['domainExternalObjectId'];
        }
        return null;
    }

    public function setForumExternalObjectId($forumExternalObjectId) {
        $this->data['forumExternalObjectId'] = $forumExternalObjectId;
    }

    public function getForumExternalObjectId() {
        if (isset($this->data['forumExternalObjectId'])) {
            return $this->data['forumExternalObjectId'];
        }
        return null;
    }

    public function setThreadId($threadId) {
        $this->data['id'] = $threadId;
    }

    public function getThreadId() {
        if (isset($this->data['threadId'])) {
            return $this->data['threadId'];
        }
        return null;
    }

    public function setContent($content) {
        $this->data['content'] = $content;
    }

    public function getContent() {
        if (isset($this->data['content'])) {
            return $this->data['content'];
        }
        return null;
    }

}
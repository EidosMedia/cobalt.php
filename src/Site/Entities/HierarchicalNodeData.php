<?php

namespace Eidosmedia\Cobalt\Site\Entities;

class HierarchicalNodeData extends NodeData {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getChildrenIds() {
        if (isset($this->data['hierarchyChildrenIds'])) {
            return $this->data['hierarchyChildrenIds'];
        }
        return null;
    }

    public function getSectionPath() {
        if (isset($this->data['pubInfo']['sectionPath'])) {
            return $this->data['pubInfo']['sectionPath'];
        }
        return null;
    }

}
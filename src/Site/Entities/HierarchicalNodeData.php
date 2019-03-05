<?php

namespace Eidosmedia\Cobalt\Site\Entities;

class HierarchicalNodeData extends NodeData {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getChildrenIds() {
        return $this->data['hierarchyChildrenIds'];
    }

    public function getSectionPath() {
        return $this->data['pubInfo']['sectionPath'];
    }

}
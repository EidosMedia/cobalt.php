<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\NodeData;

class ContentData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function getData() {
        if (isset($this->data['data'])) {
            if ($this->data['data'] instanceof NodeData) {
                return $this->data['data'];
            }
            return new NodeData($this->data['data']);
        }
        return null;
    }

    public function getNodes() {
        if (isset($this->data['nodes'])) {
            return array_map(function($el) {
                if ($el instanceof NodeData) {
                    return $el;
                }
                return new NodeData($el);
            },
            $this->data['nodes']);            
        }
        return null;
    }

    public function getChildren($node = null) {
        if ($node == null) {
            if (isset($this->data['children'])) {
                return $this->data['children'];
            }
            return null;
        } else {
            return $node->getChildren();
        }
    }

    public function getNode($id) {
        if (isset($this->data['nodes'][$id])) {
            if ($this->data['nodes'][$id] instanceof NodeData) {
                return $this->data['nodes'][$id];
            }
            return new NodeData($this->data['nodes'][$id]);
        }
        return null;
    }

    public function getChildNodes($node = null) {
        $children = array_map(function($id) {
            return $this->getNode($id); 
        }, 
        $this->getChildren($node));
        $childNodes = [];
        foreach ($children as $child) {
            $childNodes[$child->getId()] = $child;
        }
        return $childNodes;
    }

    public function getZonesNames() {
        if ($this->getData() != null && $this->getData()->getZonesNames() != null) {
            return $this->getData()->getZonesNames();
        }
        return null;
    }

    public function getZoneNodes($zoneName, $node = null) {
        if ($zoneName == null) {
            return null;
        }
        if ($node == null) {
            $node = $this->getData();
        }
        return array_map(function($id) {
            return $this->getNode($id);
        }, $node->getZoneIds($zoneName));
    }

}
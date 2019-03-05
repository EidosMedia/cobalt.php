<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\PublicationData;
use Eidosmedia\Cobalt\Site\Entities\SystemData;

class NodeData extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function getId() {
        return $this->data['id'];
    }

    public function getParentId() {
        return $this->data['parentId'];
    }

    public function getName() {
        return $this->data['name'];
    }

    public function getTitle() {
        return $this->data['title'];
    }

    public function getAuthors() {
        if (isset($this->data['authors'])) {
            return $this->data['authors'];
        } else {
            return null;
        }
    }

    public function getSummary() {
        if (isset($this->data['summary'])) {
            return $this->data['summary'];
        } else {
            return null;
        }
    }

    public function getDescription() {
        if (isset($this->data['description'])) {
            return $this->data['description'];
        } else {
            return null;
        }
    }

    public function getPictureId() {
        if (isset($this->data['picture'])) {
            return $this->data['picture'];
        } else {
            return null;
        }
    }

    public function getContent() {
        if (isset($this->data['files']) && isset($this->data['files']['content']) && isset($this->data['files']['content']['data'])) {
            return $this->data['files']['content']['data'];
        } else {
            return null;
        }
    }

    public function getPubInfo() {
        return new PublicationData($this->data['pubInfo']);
    }

    public function getSys() {
        return new SystemData($this->data['sys']);
    }

    public function transformContentDocument($xsl) {
        $contentDocument = $this->getContentDocument();
        if ($contentDocument == null) {
            return null;
        }
        if (!($xsl instanceof \DOMDocument)) {
            $xsl = \DOMDocument::loadXML($xsl);
        }
        $processor = new \XSLTProcessor();
        $processor->importStyleSheet($xsl);
        return $processor->transformToXml($contentDocument);
    }

    public function getTemplateName() {
        if (isset($this->data['attributes']) && isset($this->data['attributes']['template'])) {
            return $this->data['attributes']['template'];
        }
        return null;
    }

    private function getTemplate() {
        $templateName = $this->getTemplateName();
        if ($templateName == null) {
            return null;
        }
        return $this->data['files']['templates']['data'][$templateName];
    }

    public function getZonesNames() {
        $template = $this->getTemplate();
        if ($template == null) {
            return [];
        }
        return array_keys($template['zones']);
    }

    public function getZoneIds($zoneName) {
        $template = $this->getTemplate();
        if ($template == null) {
            return null;
        }
        $zone = $template['zones'][$zoneName];
        $sequences = $zone['sequences'];
        $maxItems = 0;
        foreach ($sequences as $sequence) {
            $maxItems += $sequence['maxItems'];
        }
        $links = $this->data['links']['pagelink'][$zoneName];
        return array_map(function($link) {
            return $link['targetId'];
        } , array_slice($links, 0, $maxItems));
    }

    public function getChildren() {
        if (isset($this->data['children'])) {
            return $this->data['children'];
        } else {
            return [];
        }
    }


}
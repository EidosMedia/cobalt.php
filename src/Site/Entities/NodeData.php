<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\PublicationData;
use Eidosmedia\Cobalt\Site\Entities\SystemData;

class NodeData extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function setContent($content) {
        $this->data['files']['content']['data'] = $content;
    }

    public function getContent() {
        if (isset($this->data['files']) && isset($this->data['files']['content']) && isset($this->data['files']['content']['data'])) {
            return $this->data['files']['content']['data'];
        }
        return null;
    }

    public function setTitle($title) {
        $this->data['title'] = $title;
    }

    public function getTitle() {
        if (isset($this->data['title'])) {
            return $this->data['title'];
        }
        return null;
    }

    public function setAuthors($authors) {
        $this->data['authors'] = $authors;
    }

    public function getAuthors() {
        if (isset($this->data['authors'])) {
            return $this->data['authors'];
        }
        return null;
    }

    public function setSummary($summary) {
        $this->data['summary'] = $summary;
    }

    public function getSummary() {
        if (isset($this->data['summary'])) {
            return $this->data['summary'];
        }
        return null;
    }

    public function setPictureId($picture) {
        $this->data['picture'] = $picture;
    }

    public function getPictureId() {
        if (isset($this->data['picture'])) {
            return $this->data['picture'];
        }
        return null;
    }

    public function getPubInfo() {
        if (isset($this->data['pubInfo'])) {
            if ($this->data['pubInfo'] instanceof PublicationData) {
                return $this->data['pubInfo'];
            }
            return new PublicationData($this->data['pubInfo']);
        }
        return null;
    }

    public function getSys() {
        if (isset($this->data['sys'])) {
            if ($this->data['sys'] instanceof SystemData) {
                return $this->data['sys'];
            }
            return new SystemData($this->data['sys']);
        }
        return null;
    }

    public function getContentDocument() {
        if (isset($this->docs['content'])) {
            return $this->docs['content'];
        }
        $content = $this->getContent();
        if ($content == null) {
            return null;
        }
        $this->docs['content'] = \DOMDocument::loadXML($content);
        return $this->docs['content'];
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
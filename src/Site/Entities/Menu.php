<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\MenuItem;

class Menu extends Entity {

    public function __construct($data) {
        parent::__construct($data);
    }

    public function setName($name) {
        $this->data['name'] = $name;
    }

    public function setDescription($description) {
        $this->data['description'] = $description;
    }

    public function setItems($items) {
        foreach ($items as $item) {
            $item = new MenuItem($item);
        }
        $this->data['items'] = $items;
    }

    public function setCreationDate($creationDate) {
        $this->data['creationDate'] = $creationDate;
    }

    public function setModificationDate($modificationDate) {
        $this->data['modificationDate'] = $modificationDate;
    }

}
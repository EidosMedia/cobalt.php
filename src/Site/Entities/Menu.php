<?php

namespace Eidosmedia\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Commons\Entity;
use Eidosmedia\Cobalt\Site\Entities\MenuItem;

class Menu extends Entity {

    public function __construct($data = null) {
        parent::__construct($data);
    }

    public function setItems($items) {
        if ($items instanceof MenuItem) {
            $this->data['items'] = [$items];

        } else if (is_array($items)) {
            foreach ($items as $item) {
                if (!$item instanceof MenuItem) {
                    $item = new MenuItem($item);
                }
            }
            $this->data['items'] = $items;
        }
    }

}
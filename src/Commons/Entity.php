<?php

namespace Eidosmedia\Cobalt\Commons;

class Entity {

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __call($name, $arguments) {
        // used for non existing methods
        if (strncmp($name, 'get', 3) === 0) {
            // the method name starts with a get
            $name = lcfirst(substr_replace($name, '', 0, 3));
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }
        }
        return null;
    }

}
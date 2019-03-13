<?php

namespace Eidosmedia\Cobalt\Commons;

class Entity {

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __call($name, $arguments) {
        // setter user for non existing methods
        if (strncmp($name, 'set', 3) === 0) {
            // the method name starts with a get
            $name = lcfirst(substr_replace($name, '', 0, 3));
            if (is_array($arguments)) {
                $this->data[$name] = $arguments[0];

            } elseif (is_scalar($arguments)) {
                $this->data[$name] = $arguments;

            } else {
                $this->data[$name] = null;
            }
            return;
        }

        // getter used for non existing methods
        if (strncmp($name, 'get', 3) === 0) {
            // the method name starts with a get
            $name = lcfirst(substr_replace($name, '', 0, 3));
            if (isset($this->data[$name])) {
                return $this->data[$name];
            }
        } else {
            return null;
        }
    }

}
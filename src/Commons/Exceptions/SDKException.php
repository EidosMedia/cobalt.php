<?php

namespace Eidosmedia\Cobalt\Commons\Exceptions;

class SDKException extends \RuntimeException {

    public function __construct($message) {
        parent::__construct($message);
    }

}
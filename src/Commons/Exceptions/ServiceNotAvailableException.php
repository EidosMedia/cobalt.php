<?php

namespace Eidosmedia\Cobalt\Commons\Exceptions;

class ServiceNotAvailableException extends SDKException {

    private $request;

    public function __construct($message, $request) {
        parent::__construct($message);
        $this->request = $request;
    }

}
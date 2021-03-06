<?php

namespace Eidosmedia\Cobalt\Commons\Exceptions;

class HttpClientException extends SDKException {

    private $statusCode;
    private $statusPhrase;
    private $body;

    public function __construct($ex, $statusCode, $statusPhrase, $body) {
        parent::__construct($ex);
        $this->statusCode = $statusCode;
        $this->statusPhrase = $statusPhrase;
        $this->body = $body;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getStatusPhrase() {
        return $this->statusPhrase;
    }

    public function getBody() {
        return $this->body;
    }

}
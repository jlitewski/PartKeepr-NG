<?php
namespace App\Exception\Core;

class InvalidEntityStateException extends \Exception {
    public function __construct($message, $code = 0, ?\Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
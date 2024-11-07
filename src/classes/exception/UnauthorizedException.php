<?php
namespace iutnc\deefy\exception;

use Exception;

class UnauthorizedException extends Exception {
    public function __construct($message = "Accès non autorisé", $code = 403, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

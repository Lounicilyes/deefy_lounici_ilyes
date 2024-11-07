<?php
namespace iutnc\deefy\exception;

use Exception;

class AuthnException extends Exception {
    public function __construct($message = "Erreur d'authentification", $code = 308, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
<?php
namespace iutnc\deefy\exception;

use Exception;

class DatabaseException extends Exception {
    public function __construct($message = "Erreur de base de données", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

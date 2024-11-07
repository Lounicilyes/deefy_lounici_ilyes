<?php
namespace iutnc\deefy\exception;

use Exception;

class NotFoundException extends Exception {
    public function __construct($message = "Ressource non trouvée", $code = 404, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

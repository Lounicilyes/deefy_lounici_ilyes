<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\dispatch\Dispatcher;

try {
    // Initialisation de DeefyRepository (chargement de la configuration dans le constructeur)
    $repository = DeefyRepository::getInstance();

    $dispatcher = new Dispatcher();
    $dispatcher->run();
} catch (Exception $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}

<?php
namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\MesPlaylistsAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\SignupAction;
use iutnc\deefy\action\SignoutAction;
use iutnc\deefy\exception\NotFoundException;
use iutnc\deefy\exception\DatabaseException;


class Dispatcher {
    private ?string $action;

    /**
     * Constructeur de la classe Dispatcher.
     * Initialise l'action à partir des paramètres de requête GET ou utilise "default" par défaut.
     */
    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    /**
     * Exécute l'action demandée en fonction du paramètre "action" de l'URL.
     * Gère les exceptions spécifiques pour les erreurs 404 et de base de données.
     */
    public function run(): void {
        try {
            // Sélectionne l'action en fonction du paramètre 'action' passé dans l'URL
            switch ($this->action) {
                case 'mes-playlists':
                    $action = new MesPlaylistsAction();
                    $html = $action->execute();
                    break;
                case 'add-playlist':
                    $action = new AddPlaylistAction();
                    $html = $action->execute();
                    break;
                case 'display-playlist':
                    $action = new DisplayPlaylistAction();
                    $html = $action->execute();
                    break;
                case 'add-track':
                    $action = new AddTrackAction();
                    $html = $action->execute();
                    break;
                case 'signin':
                    $action = new SigninAction();
                    $html = $action->execute();
                    break;
                case 'signup':
                    $action = new SignupAction();
                    $html = $action->execute();
                    break;
                case 'signout':
                    $action = new SignoutAction();
                    $html = $action->execute();
                    break;
                case 'default':
                    $action = new DefaultAction();
                    $html = $action->execute();
                    break;
                default:
                    // Lève une exception si l'action est inconnue
                    throw new NotFoundException("Action non trouvée : " . $this->action);
            }

            // Affiche la page avec le contenu généré par l'action
            $this->renderPage($html);

        } catch (NotFoundException $e) {
            // Affiche un message d'erreur pour une action non trouvée
            $this->renderPage("<h2>Erreur 404 - Ressource non trouvée</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
        } catch (DatabaseException $e) {
            // Affiche un message d'erreur pour une erreur de base de données
            $this->renderPage("<h2>Erreur de base de données</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
        }
    }

    /**
     * Affiche le contenu HTML généré par une action dans une structure de page.
     *
     * @param string $html Contenu HTML généré par l'action.
     */
    private function renderPage(string $html): void {
        $isLoggedIn = \iutnc\deefy\auth\AuthnProvider::isUserLoggedIn();

        echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DeefyApp</title>
    <link rel="stylesheet" href="src/css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur Deefy</h1>
    </header>
    <nav>
        <a href="?action=default">Accueil</a> |
        <a href="?action=signin">Se connecter</a> |
        <a href="?action=signup">S'inscrire</a> |
        <a href="?action=mes-playlists">Mes Playlists</a> |
        <a href="?action=add-playlist">Créer une Playlist</a> |
HTML;

        if ($isLoggedIn) {
            echo '<a href="?action=signout">Déconnexion</a>';
        }

        echo <<<HTML
    </nav>
    <div class="container">
        $html
    </div>
    <footer>
        <p>&copy; Deefy - LOUNICI Ilyès</p>
    </footer>
</body>
</html>
HTML;
    }


}

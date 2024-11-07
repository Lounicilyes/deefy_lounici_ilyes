<?php
namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\MesPlaylistsAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\SignupAction;
use iutnc\deefy\exception\NotFoundException;
use iutnc\deefy\exception\DatabaseException;

class Dispatcher {
    private ?string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {
        try {
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
                case 'default':
                    $action = new DefaultAction();
                    $html = $action->execute();
                    break;
                default:
                    throw new NotFoundException("Action non trouvée : " . $this->action);
            }

            $this->renderPage($html);

        } catch (NotFoundException $e) {
            $this->renderPage("<h2>Erreur 404 - Ressource non trouvée</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
        } catch (DatabaseException $e) {
            $this->renderPage("<h2>Erreur de base de données</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
        }
    }

    private function renderPage(string $html): void {
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
            <h1>Bienvenue sur DeefyApp</h1>
        </header>
        <nav>
            <a href="?action=default">Accueil</a> |
            <a href="?action=signin">Se connecter</a> |
            <a href="?action=signup">S'inscrire</a> |
            <a href="?action=mes-playlists">Mes Playlists</a> |
            <a href="?action=add-playlist">Créer une Playlist</a>
        </nav>
        <div class="container">
            $html
        </div>
        <footer>
            <p>&copy; DeefyApp - Tous droits réservés</p>
        </footer>
    </body>
    </html>
    HTML;
    }

}

<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\auth\AuthnProvider; // Import de AuthnProvider pour gérer l'authentification
use iutnc\deefy\audio\list\Playlist;

class AddPlaylistAction extends Action {

    /**
     * Point d'entrée principal de l'action pour ajouter une playlist.
     * Selon la méthode HTTP (GET ou POST), il dirige vers le bon gestionnaire.
     *
     * @return string Le contenu HTML à afficher après l'exécution de l'action.
     */
    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    /**
     * Génère et retourne le formulaire HTML pour créer une nouvelle playlist.
     * Utilisée lorsque l'utilisateur accède à la page via la méthode GET.
     *
     * @return string Le contenu HTML du formulaire.
     */
    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=add-playlist">
            <label>Nom de la playlist : <input type="text" name="playlist_name" required></label>
            <button type="submit">Créer la playlist</button>
        </form>
        HTML;
    }

    /**
     * Gère la soumission du formulaire de création de playlist.
     * Vérifie si l'utilisateur est connecté, récupère le nom de la playlist depuis le formulaire,
     * crée la playlist dans la base de données, puis associe cette playlist à l'utilisateur.
     *
     * @return string Message de confirmation ou d'erreur après l'ajout de la playlist.
     */
    protected function handlePost(): string {
        // Démarre la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si l'utilisateur est connecté
        $user = AuthnProvider::getSignedInUser();
        if ($user === null) {
            return "<p>Vous devez être connecté pour créer une playlist.</p>";
        }

        // Filtre et récupère le nom de la playlist soumis par l'utilisateur
        $playlistName = filter_var($_POST['playlist_name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $playlist = new Playlist(0, $playlistName);
        $pdo = DeefyRepository::getInstance();

        // Enregistre la playlist dans la base de données
        $pdo->savePlaylist($playlist);

        // Associe la playlist nouvellement créée à l'utilisateur connecté
        $pdo->associatePlaylistWithUser($user->getId(), $playlist);

        // Retourne un message de succès avec un lien pour voir les playlists
        return "<p>Playlist '$playlistName' créée avec succès.</p><a href='?action=mes-playlists'>Voir mes playlists</a>";
    }
}

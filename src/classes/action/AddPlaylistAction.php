<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\auth\AuthnProvider; // Import de AuthnProvider
use iutnc\deefy\audio\list\Playlist;

class AddPlaylistAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=add-playlist">
            <label>Nom de la playlist : <input type="text" name="playlist_name" required></label>
            <button type="submit">Créer la playlist</button>
        </form>
        HTML;
    }

    protected function handlePost(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = AuthnProvider::getSignedInUser();
        if ($user === null) {
            return "<p>Vous devez être connecté pour créer une playlist.</p>";
        }

        $playlistName = filter_var($_POST['playlist_name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $playlist = new Playlist(0, $playlistName);
        $pdo = DeefyRepository::getInstance();

        // Enregistrez la playlist
        $pdo->savePlaylist($playlist);

        // Associez la playlist à l'utilisateur dans la table user2playlist
        $pdo->associatePlaylistWithUser($user->getId(), $playlist);

        return "<p>Playlist '$playlistName' créée avec succès.</p><a href='?action=mes-playlists'>Voir mes playlists</a>";
    }
}

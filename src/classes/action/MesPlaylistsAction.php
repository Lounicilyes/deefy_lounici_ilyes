<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\PlaylistRenderer;

class MesPlaylistsAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    protected function handleGet(): string {
        if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
            return "<p>Erreur : Vous devez être connecté pour voir vos playlists.</p>";
        }

        $playlists = DeefyRepository::getInstance()->findPlaylistsByUser($_SESSION['user']['id']);
        $html = "<h2>Mes Playlists</h2>";

        if (empty($playlists)) {
            return "<p>Vous n'avez aucune playlist.</p><a href='?action=add-playlist'>Créer une nouvelle playlist</a>";
        }

        $html .= "<form method='post' action='?action=mes-playlists'>
                    <label>Sélectionnez une playlist :</label>
                    <select name='playlist_id' required>";
        foreach ($playlists as $playlist) {
            $html .= "<option value='{$playlist->getId()}'>{$playlist->getName()}</option>";
        }
        $html .= "</select>
                  <button type='submit'>Choisir cette playlist</button>
                  </form>";

        return $html;
    }

    protected function handlePost(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $playlistId = filter_var($_POST['playlist_id'], FILTER_VALIDATE_INT);

        if ($playlistId) {
            $_SESSION['current_playlist'] = $playlistId;
            return "<p>Playlist sélectionnée avec succès.</p><a href='?action=display-playlist'>Voir la playlist</a>";
        } else {
            return "<p>Erreur : Aucune playlist sélectionnée.</p>";
        }
    }
}

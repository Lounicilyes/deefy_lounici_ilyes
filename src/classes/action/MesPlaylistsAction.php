<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\PlaylistRenderer;

class MesPlaylistsAction extends Action {

    /**
     * Point d'entrée pour l'exécution de l'action.
     * Appelle `handlePost` si la méthode HTTP est POST, sinon `handleGet`.
     *
     * @return string Le contenu HTML de la page.
     */
    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    /**
     * Affiche les playlists de l'utilisateur connecté.
     * Si aucune playlist n'est trouvée, propose de créer une nouvelle playlist.
     *
     * @return string Le contenu HTML pour afficher les playlists ou un message d'erreur.
     */
    protected function handleGet(): string {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
            return "<p>Erreur : Vous devez être connecté pour voir vos playlists.</p>";
        }

        // Récupère les playlists de l'utilisateur depuis le repository
        $playlists = DeefyRepository::getInstance()->findPlaylistsByUser($_SESSION['user']['id']);
        $html = "<h2>Mes Playlists</h2>";

        // Si l'utilisateur n'a pas de playlists, propose d'en créer une
        if (empty($playlists)) {
            return "<p>Vous n'avez aucune playlist.</p><a href='?action=add-playlist'>Créer une nouvelle playlist</a>";
        }

        // Affiche un formulaire avec la liste des playlists pour en sélectionner une
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

    /**
     * Traite la sélection d'une playlist et enregistre l'ID de la playlist sélectionnée dans la session.
     *
     * @return string Un message confirmant la sélection de la playlist, ou une erreur si la sélection a échoué.
     */
    protected function handlePost(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Valide l'ID de la playlist envoyée via le formulaire
        $playlistId = filter_var($_POST['playlist_id'], FILTER_VALIDATE_INT);

        // Si l'ID de la playlist est valide, l'enregistre dans la session
        if ($playlistId) {
            $_SESSION['current_playlist'] = $playlistId;
            return "<p>Playlist sélectionnée avec succès.</p><a href='?action=display-playlist'>Voir la playlist</a>";
        } else {
            return "<p>Erreur : Aucune playlist sélectionnée.</p>";
        }
    }
}

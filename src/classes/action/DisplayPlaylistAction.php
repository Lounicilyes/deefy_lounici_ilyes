<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\TrackRenderer;

class DisplayPlaylistAction extends Action {

    public function execute(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['current_playlist'])) {
            return "<p>Veuillez d'abord sélectionner une playlist.</p><a href='?action=mes-playlists'>Sélectionner une playlist</a>";
        }

        $playlistId = $_SESSION['current_playlist'];
        $tracks = DeefyRepository::getInstance()->getTracksByPlaylist($playlistId);

        if (empty($tracks)) {
            return "<p>Cette playlist ne contient aucune piste.</p><a href='?action=add-track'>Ajouter une piste</a>";
        }

        $html = "<h2>Contenu de la playlist</h2><ul>";
        foreach ($tracks as $track) {
            $renderer = new TrackRenderer();
            $html .= "<li>" . $renderer->render($track) . "</li>";
        }
        $html .= "</ul><a href='?action=add-track'>Ajouter une piste</a>";

        return $html;
    }
}

<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\TrackRenderer;

class DisplayPlaylistAction extends Action {

    /**
     * Point d'entrée de l'action pour afficher le contenu d'une playlist.
     * Vérifie si une playlist est sélectionnée dans la session et, si oui, affiche les pistes.
     *
     * @return string Le contenu HTML de la playlist ou un message si aucune piste n'est disponible.
     */
    public function execute(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si une playlist est sélectionnée
        if (!isset($_SESSION['current_playlist'])) {
            return "<p>Veuillez d'abord sélectionner une playlist.</p><a href='?action=mes-playlists'>Sélectionner une playlist</a>";
        }

        // Récupère les pistes de la playlist
        $playlistId = $_SESSION['current_playlist'];
        $tracks = DeefyRepository::getInstance()->getTracksByPlaylist($playlistId);

        // Vérifie si la playlist contient des pistes
        if (empty($tracks)) {
            return "<p>Cette playlist ne contient aucune piste.</p><a href='?action=add-track'>Ajouter une piste</a>";
        }

        // Génère le contenu HTML de la playlist avec ses pistes
        $html = "<h2>Contenu de la playlist</h2><ul>";
        foreach ($tracks as $track) {
            $renderer = new TrackRenderer();
            $html .= "<li>" . $renderer->render($track) . "</li>";
        }
        $html .= "</ul><a href='?action=add-track'>Ajouter une piste</a>";

        return $html;
    }
}

<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\list\Playlist;

class PlaylistRenderer {
    private Playlist $playlist;

    /**
     * Constructeur de PlaylistRenderer
     *
     * @param Playlist $playlist L'instance de Playlist à afficher
     */
    public function __construct(Playlist $playlist) {
        $this->playlist = $playlist;
    }

    /**
     * Génère le code HTML pour afficher la playlist.
     *
     * Cette méthode crée un lien pour accéder au contenu de la playlist
     * et affiche les pistes audio associées en utilisant TrackRenderer.
     *
     * @return string Le code HTML de la playlist et de ses pistes
     */
    public function render(): string {
        $html = "<h3><a href='?action=display-playlist&playlist_id={$this->playlist->getId()}'>{$this->playlist->getName()}</a></h3><ul>";

        // Parcourt chaque piste de la playlist et utilise TrackRenderer pour l'afficher
        foreach ($this->playlist->getTracks() as $track) {
            $trackRenderer = new TrackRenderer();
            $html .= "<li>" . $trackRenderer->render($track) . "</li>";
        }

        $html .= "</ul>";
        return $html;
    }
}


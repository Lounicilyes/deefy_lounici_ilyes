<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\list\Playlist;

class PlaylistRenderer {
    private Playlist $playlist;

    public function __construct(Playlist $playlist) {
        $this->playlist = $playlist;
    }

    public function render(): string {
        $html = "<h3><a href='?action=display-playlist&playlist_id={$this->playlist->getId()}'>{$this->playlist->getName()}</a></h3><ul>";
        foreach ($this->playlist->getTracks() as $track) {
            $trackRenderer = new TrackRenderer();
            $html .= "<li>" . $trackRenderer->render($track) . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }
}
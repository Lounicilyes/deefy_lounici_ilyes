<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\list\Track;

class TrackRenderer {

    public function render(Track $track): string {
        $html = "<div class='track'>";
        $html .= "<h3>" . htmlspecialchars($track->getTitle()) . "</h3>";
        $html .= "<p>Genre: " . htmlspecialchars($track->getGenre()) . "</p>";
        $html .= "<p>Durée: " . htmlspecialchars($track->getDuration()) . " secondes</p>";

        $fileUrl = "/deefy_lounici_ilyes/audio/" . basename($track->getFile());
        $html .= "<audio controls>
            <source src='$fileUrl' type='audio/mpeg'>
            Votre navigateur ne supporte pas la balise audio.
          </audio>";


        $html .= "</div>";
        return $html;
    }
}
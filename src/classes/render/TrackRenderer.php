<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\list\Track;

class TrackRenderer {

    /**
     * Génère le code HTML pour afficher une piste audio.
     *
     * Cette méthode affiche les informations de la piste (titre, genre, durée)
     * et inclut un lecteur audio pour écouter la piste.
     *
     * @param Track $track La piste audio à afficher
     * @return string Le code HTML de la piste audio
     */
    public function render(Track $track): string {
        $html = "<div class='track'>";

        // Affiche le titre de la piste avec protection contre les caractères spéciaux
        $html .= "<h3>" . htmlspecialchars($track->getTitle()) . "</h3>";

        // Affiche le genre de la piste
        $html .= "<p>Genre: " . htmlspecialchars($track->getGenre()) . "</p>";

        // Affiche la durée de la piste en secondes
        $html .= "<p>Durée: " . htmlspecialchars($track->getDuration()) . " secondes</p>";

        // Génère l'URL du fichier audio pour le lecteur audio
        $fileUrl = "/deefy_lounici_ilyes/audio/" . basename($track->getFile());

        // Intègre le lecteur audio pour lire la piste
        $html .= "<audio controls>
            <source src='$fileUrl' type='audio/mpeg'>
            Votre navigateur ne supporte pas la balise audio.
          </audio>";

        $html .= "</div>";
        return $html;
    }
}

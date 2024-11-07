<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\list\Track;
use iutnc\deefy\exception\DatabaseException;

class AddTrackAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    protected function handleGet(): string {
        if (!isset($_SESSION['current_playlist'])) {
            return "<p>Veuillez d'abord sélectionner une playlist.</p><a href='?action=mes-playlists'>Sélectionner une playlist</a>";
        }

        return <<<HTML
        <form method="post" action="?action=add-track" enctype="multipart/form-data">
            <label>Titre de la piste : <input type="text" name="track_title" required></label>
            <label>Genre : <input type="text" name="genre" required></label>
            <label>Durée (secondes) : <input type="number" name="duration" required></label>
            <label>Fichier audio : <input type="file" name="audio_file" accept=".mp3" required></label>
            <button type="submit">Ajouter la piste</button>
        </form>
        HTML;
    }

    protected function handlePost(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['current_playlist'])) {
            return "<p>Veuillez d'abord sélectionner une playlist.</p><a href='?action=mes-playlists'>Sélectionner une playlist</a>";
        }

        $title = filter_var($_POST['track_title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $genre = filter_var($_POST['genre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT);
        $audioFile = $_FILES['audio_file'];

        if ($audioFile['error'] !== UPLOAD_ERR_OK) {
            return "<p>Erreur lors de l'upload du fichier audio.</p>";
        }

        if ($audioFile['type'] !== 'audio/mpeg') {
            return "<p>Erreur : Le fichier doit être au format .mp3.</p>";
        }

        $uploadDir = '/var/www/html/deefy_lounici_ilyes/audio/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . uniqid() . '.mp3';
        if (move_uploaded_file($audioFile['tmp_name'], $filePath)) {
            $track = new Track(0, $title, $genre, $duration, $filePath);
            DeefyRepository::getInstance()->addTrackToPlaylist($track, $_SESSION['current_playlist']);
            return "<p>Piste '$title' ajoutée à la playlist courante.</p><a href='?action=display-playlist'>Voir la playlist</a>";
        } else {
            throw new DatabaseException("Erreur lors de l'upload du fichier audio.");
        }
    }
}

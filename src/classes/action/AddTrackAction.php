<?php
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\list\Track;
use iutnc\deefy\exception\DatabaseException;

class AddTrackAction extends Action {

    /**
     * Point d'entrée principal de l'action pour ajouter une piste audio.
     * Selon la méthode HTTP (GET ou POST), il dirige vers le bon gestionnaire.
     *
     * @return string Le contenu HTML à afficher après l'exécution de l'action.
     */
    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    /**
     * Génère et retourne le formulaire HTML pour ajouter une nouvelle piste audio.
     * Utilisée lorsque l'utilisateur accède à la page via la méthode GET.
     *
     * @return string Le contenu HTML du formulaire.
     */
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

    /**
     * Gère la soumission du formulaire d'ajout de piste audio.
     * Vérifie si une playlist est sélectionnée, valide les données de la piste audio,
     * enregistre le fichier audio sur le serveur et ajoute la piste à la playlist dans la base de données.
     *
     * @return string Message de confirmation ou d'erreur après l'ajout de la piste.
     * @throws DatabaseException Si une erreur survient lors du déplacement du fichier audio.
     */
    protected function handlePost(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si une playlist est sélectionnée
        if (!isset($_SESSION['current_playlist'])) {
            return "<p>Veuillez d'abord sélectionner une playlist.</p><a href='?action=mes-playlists'>Sélectionner une playlist</a>";
        }

        // Filtrage des données du formulaire
        $title = filter_var($_POST['track_title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $genre = filter_var($_POST['genre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT);
        $audioFile = $_FILES['audio_file'];

        // Vérifie les erreurs de téléchargement
        if ($audioFile['error'] !== UPLOAD_ERR_OK) {
            return "<p>Erreur lors de l'upload du fichier audio.</p>";
        }

        // Vérifie le type de fichier
        if ($audioFile['type'] !== 'audio/mpeg') {
            return "<p>Erreur : Le fichier doit être au format .mp3.</p>";
        }

        // Chemin du répertoire pour stocker les fichiers audio
        $uploadDir = '/var/www/html/deefy_lounici_ilyes/audio/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Génère un nom de fichier unique et déplace le fichier
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

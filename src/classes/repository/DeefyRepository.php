<?php
namespace iutnc\deefy\repository;

use PDO;
use PDOException;
use Exception;
use iutnc\deefy\audio\list\User;
use iutnc\deefy\audio\list\Playlist;
use iutnc\deefy\audio\list\Track;
use iutnc\deefy\exception\DatabaseException;

class DeefyRepository
{
    private PDO $pdo;
    private static ?DeefyRepository $instance = null;

    /**
     * Retourne l'instance unique de `DeefyRepository` (Singleton).
     *
     * @return self L'instance de `DeefyRepository`.
     */
    public static function getInstance(): self {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructeur privé pour le pattern Singleton.
     *
     * Initialise la connexion à la base de données en utilisant un fichier de configuration.
     *
     * @throws DatabaseException Si le fichier de configuration est manquant ou si la connexion échoue.
     */
    private function __construct() {
        $config = parse_ini_file('/var/www/html/deefy_lounici_ilyes/config/db.config.ini');

        if (!$config || !isset($config['driver'], $config['host'], $config['database'], $config['username'], $config['password'])) {
            throw new DatabaseException("Fichier de configuration de la base de données manquant ou incomplet.");
        }

        try {
            $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
            $this->pdo = new PDO($dsn, $config['username'], $config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseException("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Récupère un utilisateur par son email.
     *
     * @param string $email L'email de l'utilisateur.
     * @return User|null L'objet User correspondant.
     * @throws NotFoundException Si aucun utilisateur n'est trouvé avec cet email.
     */
    public function getUser(string $email): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row === false) {
            throw new NotFoundException("Utilisateur non trouvé avec l'email: $email");
        }

        return new User($row['id'], $row['email'], $row['role'], $row['passwd']);
    }

    /**
     * Vérifie si un email est déjà utilisé dans la base de données.
     *
     * @param string $email L'email à vérifier.
     * @return bool True si l'email est pris, False sinon.
     */
    public function isEmailTaken(string $email): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM User WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Récupère toutes les playlists appartenant à un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @return array Un tableau d'objets Playlist appartenant à l'utilisateur.
     * @throws DatabaseException En cas d'erreur lors de la récupération des playlists.
     */
    public function findPlaylistsByUser(int $userId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT p.*
                FROM playlist p
                JOIN user2playlist up ON p.id = up.id_pl
                WHERE up.id_user = :userId
            ");
            $stmt->execute(['userId' => $userId]);
            $playlists = [];

            while ($row = $stmt->fetch()) {
                $playlist = new Playlist((int)$row['id'], $row['nom']);
                $playlists[] = $playlist;
            }

            return $playlists;
        } catch (PDOException $e) {
            throw new DatabaseException("Erreur lors de la récupération des playlists : " . $e->getMessage());
        }
    }

    /**
     * Ajoute un nouvel utilisateur dans la base de données.
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe en clair.
     * @throws Exception Si l'email est déjà pris.
     */
    public function addUser(string $email, string $password): void {
        if ($this->isEmailTaken($email)) {
            throw new Exception("Cet email est déjà enregistré.");
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO User (email, passwd, role) VALUES (?, ?, 1)");
        $stmt->execute([$email, $hash]);
    }

    /**
     * Enregistre une nouvelle playlist dans la base de données.
     *
     * @param Playlist $playlist L'objet Playlist à enregistrer.
     */
    public function savePlaylist(Playlist $playlist): void {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $playlist->getName()]);
    }

    /**
     * Associe une playlist à un utilisateur.
     *
     * @param int $userId L'ID de l'utilisateur.
     * @param Playlist $playlist La playlist à associer.
     */
    public function associatePlaylistWithUser(int $userId, Playlist $playlist): void {
        $playlistId = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("INSERT INTO user2playlist (id_user, id_pl) VALUES (:id_user, :id_pl)");
        $stmt->execute([
            'id_user' => $userId,
            'id_pl' => $playlistId
        ]);
    }

    /**
     * Ajoute une piste audio à une playlist.
     *
     * @param Track $track L'objet Track à ajouter.
     * @param int $playlistId L'ID de la playlist.
     * @throws DatabaseException En cas d'erreur lors de l'ajout de la piste.
     */
    public function addTrackToPlaylist(Track $track, int $playlistId): void {
        $stmt = $this->pdo->prepare("INSERT INTO track (titre, genre, duree, filename) VALUES (:titre, :genre, :duree, :filename)");
        $stmt->execute([
            'titre' => $track->getTitle(),
            'genre' => $track->getGenre(),
            'duree' => $track->getDuration(),
            'filename' => $track->getFile()
        ]);

        $trackId = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM playlist2track WHERE id_pl = :playlist_id");
        $stmt->execute(['playlist_id' => $playlistId]);
        $no_piste_dans_liste = $stmt->fetchColumn() + 1;

        $stmt = $this->pdo->prepare("INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:id_pl, :id_track, :no_piste_dans_liste)");
        $stmt->execute([
            'id_pl' => $playlistId,
            'id_track' => $trackId,
            'no_piste_dans_liste' => $no_piste_dans_liste
        ]);
    }

    /**
     * Récupère toutes les pistes associées à une playlist.
     *
     * @param int $playlistId L'ID de la playlist.
     * @return array Un tableau d'objets Track.
     */
    public function getTracksByPlaylist(int $playlistId): array {
        $stmt = $this->pdo->prepare("
            SELECT t.id, t.titre, t.genre, t.duree, t.filename
            FROM track t
            JOIN playlist2track p2t ON t.id = p2t.id_track
            WHERE p2t.id_pl = :playlistId
        ");
        $stmt->execute(['playlistId' => $playlistId]);

        $tracks = [];
        while ($row = $stmt->fetch()) {
            $tracks[] = new Track(
                (int) $row['id'],
                $row['titre'] ?? 'Titre inconnu',
                $row['genre'] ?? 'Genre inconnu',
                (int) ($row['duree'] ?? 0),
                $row['filename'] ?? ''
            );
        }
        return $tracks;
    }
}

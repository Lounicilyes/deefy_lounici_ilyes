<?php
namespace iutnc\deefy\auth;

use Exception;
use iutnc\deefy\repository\DeefyRepository;

class Authz {
    private array $user;

    public function __construct(array $user) {
        $this->user = $user;
    }

    public function checkPlaylistOwner(int $playlistId): void {
        $pdo = DeefyRepository::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT id_user FROM user2playlist WHERE id_pl = ?");
        $stmt->execute([$playlistId]);
        $ownerId = $stmt->fetchColumn();

        if ($ownerId === false) {
            throw new Exception("Playlist non trouvée.");
        }

        if ($ownerId !== $this->user['id']) {
            throw new Exception("Accès refusé : vous n'êtes pas le propriétaire de cette playlist.");
        }
    }
}
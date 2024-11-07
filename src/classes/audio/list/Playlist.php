<?php
namespace iutnc\deefy\audio\list;

class Playlist {
    private int $id;
    private string $name;
    private array $tracks = [];

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    // Getter pour l'ID de la playlist
    public function getId(): int {
        return $this->id;
    }

    // Getter pour le nom de la playlist
    public function getName(): string {
        return $this->name;
    }

    // Ajoute une piste à la playlist
    public function addTrack(Track $track): void {
        $this->tracks[] = $track;
    }

    // Getter pour les pistes de la playlist
    public function getTracks(): array {
        return $this->tracks;
    }
}

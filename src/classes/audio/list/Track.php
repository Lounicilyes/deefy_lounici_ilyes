<?php
namespace iutnc\deefy\audio\list;

class Track {
    private int $id;
    private string $title;
    private string $genre;
    private int $duration;
    private string $file;

    public function __construct(int $id, string $title, string $genre, int $duration, string $file) {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->file = $file;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getGenre(): string {
        return $this->genre;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getFile(): string {
        return $this->file;
    }
}
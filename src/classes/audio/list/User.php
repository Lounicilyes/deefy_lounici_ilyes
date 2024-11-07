<?php
namespace iutnc\deefy\audio\list;

class User {
    private int $id;
    private string $email;
    private int $role;
    private string $password;

    public function __construct(int $id, string $email, int $role, string $password) {
        $this->id = $id;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRole(): int {
        return $this->role;
    }

    public function getPassword(): string {
        return $this->password;
    }
}

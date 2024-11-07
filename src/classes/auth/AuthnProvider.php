<?php
namespace iutnc\deefy\auth;

use Exception;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\list\User;
use iutnc\deefy\exception\AuthnException;
use iutnc\deefy\exception\UnauthorizedException;


class AuthnProvider {
    /**
     * Inscription d'un nouvel utilisateur.
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe en clair de l'utilisateur.
     * @throws Exception Si l'email est déjà enregistré ou si le mot de passe est trop court.
     */
    public static function register(string $email, string $password): void {
//        if (strlen($password) < 10) {
//            throw new Exception("Le mot de passe doit contenir au moins 10 caractères.");
//        }

        $pdo = DeefyRepository::getInstance();
        try{
            $pdo->addUser($email, $password);
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    /**
     * Connexion d'un utilisateur.
     *
     * @param string $email L'email de l'utilisateur.
     * @param string $password Le mot de passe en clair de l'utilisateur.
     * @throws Exception Si les informations d'identification sont incorrectes.
     */
    public static function signin(string $email, string $password): void {
        $repo = DeefyRepository::getInstance();
        try {
            $user = $repo->getUser($email);

            if (password_verify($password, $user->getPassword())) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole()
                ];
            } else {
                throw new AuthnException("Identifiants incorrects.");
            }
        } catch (\Exception $e) {
            throw new AuthnException("Erreur : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'utilisateur actuellement connecté.
     *
     * @return User|null L'utilisateur connecté ou null si aucun utilisateur n'est connecté.
     */
    public static function getSignedInUser(): ?User {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            // Créer un nouvel objet User à partir des données de session
            return new User(
                $_SESSION['user']['id'],
                $_SESSION['user']['email'],
                $_SESSION['user']['role'],
                '' // Le mot de passe n'est pas stocké dans la session pour des raisons de sécurité
            );
        }
        return null;
    }



    public static function isUserLoggedIn(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']['id']);
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public static function signout(): void {
        unset($_SESSION['user']);
    }
}

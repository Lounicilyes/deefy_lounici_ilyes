<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SigninAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=signin">
            <label>Email : <input type="email" name="email" required></label>
            <label>Mot de passe : <input type="password" name="passwd" required></label>
            <button type="submit">Se connecter</button>
        </form>
        HTML;
    }

    protected function handlePost(): string {
        try {
            AuthnProvider::signin($_POST['email'], $_POST['passwd']);
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['user'])) {
                return "<p>Connexion réussie.</p><a href='?action=mes-playlists'>Voir mes playlists</a>";
            } else {
                return "<p>Erreur : Identifiants incorrects.</p>";
            }
        } catch (\Exception $e) {
            return "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}
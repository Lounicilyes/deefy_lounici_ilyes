<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SignupAction extends Action {

    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=signup">
            <label>Email : <input type="email" name="email" required></label>
            <label>Mot de passe : <input type="password" name="passwd" required></label>
            <button type="submit">S'inscrire</button>
        </form>
        HTML;
    }

    protected function handlePost(): string {
        try {
            AuthnProvider::register($_POST['email'], $_POST['passwd']);
            return "<p>Inscription réussie ! <a href='?action=signin'>Connectez-vous</a></p>";
        } catch (\Exception $e) {
            return "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}

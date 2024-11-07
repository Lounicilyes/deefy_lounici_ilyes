<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SigninAction extends Action {

    /**
     * Point d'entrée pour l'exécution de l'action.
     * Appelle `handlePost` si la méthode HTTP est POST, sinon `handleGet`.
     *
     * @return string Le contenu HTML de la page.
     */
    public function execute(): string {
        if ($this->http_method === 'POST') {
            return $this->handlePost();
        }
        return $this->handleGet();
    }

    /**
     * Affiche le formulaire de connexion.
     * Le formulaire recueille l'email et le mot de passe de l'utilisateur.
     *
     * @return string Le contenu HTML du formulaire de connexion.
     */
    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=signin">
            <label>Email : <input type="email" name="email" required></label>
            <label>Mot de passe : <input type="password" name="passwd" required></label>
            <button type="submit">Se connecter</button>
        </form>
        HTML;
    }

    /**
     * Traite la tentative de connexion de l'utilisateur.
     * Utilise la méthode `signin` de `AuthnProvider` pour vérifier les informations d'identification.
     * En cas de succès, la session est initialisée pour l'utilisateur.
     *
     * @return string Un message de confirmation en cas de connexion réussie, ou un message d'erreur.
     */
    protected function handlePost(): string {
        try {
            // Tentative de connexion via AuthnProvider
            AuthnProvider::signin($_POST['email'], $_POST['passwd']);

            // Démarre la session si elle n'est pas déjà active
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Vérifie si la session contient les informations utilisateur
            if (isset($_SESSION['user'])) {
                return "<p>Connexion réussie.</p><a href='?action=mes-playlists'>Voir mes playlists</a>";
            } else {
                return "<p>Erreur : Identifiants incorrects.</p>";
            }
        } catch (\Exception $e) {
            // Affiche un message d'erreur en cas d'exception
            return "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}

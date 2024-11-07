<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SignupAction extends Action {

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
     * Affiche le formulaire d'inscription.
     * Le formulaire recueille l'email et le mot de passe de l'utilisateur.
     *
     * @return string Le contenu HTML du formulaire d'inscription.
     */
    protected function handleGet(): string {
        return <<<HTML
        <form method="post" action="?action=signup">
            <label>Email : <input type="email" name="email" required></label>
            <label>Mot de passe : <input type="password" name="passwd" required></label>
            <button type="submit">S'inscrire</button>
        </form>
        HTML;
    }

    /**
     * Traite la demande d'inscription de l'utilisateur.
     * Utilise la méthode `register` de `AuthnProvider` pour enregistrer les informations de l'utilisateur.
     * En cas de succès, un message de confirmation est affiché.
     *
     * @return string Un message de confirmation en cas d'inscription réussie, ou un message d'erreur.
     */
    protected function handlePost(): string {
        try {
            // Tentative d'inscription via AuthnProvider
            AuthnProvider::register($_POST['email'], $_POST['passwd']);

            // Message de confirmation après inscription réussie
            return "<p>Inscription réussie ! <a href='?action=signin'>Connectez-vous</a></p>";
        } catch (\Exception $e) {
            // Affiche un message d'erreur en cas d'exception
            return "<p>Erreur : " . $e->getMessage() . "</p>";
        }
    }
}

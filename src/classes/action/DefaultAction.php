<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {

    /**
     * Affiche la page d'accueil par défaut
     *
     * @return string Le contenu HTML de la page d'accueil
     */
    public function execute(): string {
        return <<<HTML
        <h1>Bienvenue sur Deefy !</h1>
        <p>Ceci est la page d'accueil de l'application Deefy.</p>
        <p>Utilisez la barre de navigation pour explorer les fonctionnalités.</p>
        <p><a href="?action=signin">Se connecter</a> ou <a href="?action=signup">S'inscrire</a> pour commencer.</p>
        HTML;
    }
}

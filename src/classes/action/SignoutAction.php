<?php
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;

class SignoutAction extends Action {

    public function execute(): string {
        AuthnProvider::signout();
        return "<p>Vous avez été déconnecté avec succès.</p><a href='?action=signin'>Se connecter</a>";
    }
}

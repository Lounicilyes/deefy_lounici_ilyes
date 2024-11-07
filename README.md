Mini-Projet Deefy - Ilyes Lounici - S3A

Bienvenue sur le dépôt du projet Deefy, une application web de gestion de playlists et de pistes audio, réalisée dans le cadre des TD.

Ce dépôt inclut :

    README.md (ce fichier)
    Interface de l'application Deefy (visible dans le code)
    Configuration de la base de données (ScriptSql.txt pour les tables, et src/repository/Config.db.ini pour la connexion)
La connexion à la base de données se configure dans src/repository/Config.db.ini en modifiant les paramètres.

Toutes les fonctionnalités clés sont implémentées dans Deefy. 
Les utilisateurs peuvent créer leurs playlists, y ajouter des pistes et les consulter.
Les utilisateurs connectés ont accès à leurs playlists et pistes.
Les utilisateurs non connectés sont invités à s'inscrire ou se connecter pour accéder aux fonctionnalités.
Les mots de passe sont sécurisés en base de données avec password_hash().

(Autre détail : Un bouton de déconnexion est disponible pour renforcer la sécurité et faciliter les tests.)

Autres améliorations apportées

    Sécurité : Les mots de passe sont stockés de manière sécurisée, avec protections contre les injections XSS et SQL.
    Code HTML conforme : Le code HTML suit les meilleures pratiques.
    Style CSS : Un design simple et épuré a été appliqué pour rendre l'interface agréable.

    Note : La fonctionnalité de restriction d’accès aux playlists en fonction du rôle de l'utilisateur ou de son statut de propriétaire reste à développer.


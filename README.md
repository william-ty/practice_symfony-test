## Projet Symfony Test-Technique

Projet reprennant les elements de réponse à un test technique pour un poste de développeur.
(voir REPONSES_TEST_TECHNIQUE.php)


Version 5.4

TODO: Partie Front-End 
_____________________________________

### Lancement du projet

- Installer les dépendances (`composer install`)
- Copier le fichier `.env-example` et le renommer env `.env`
- Définir les identifiants à la base de données
- Créer la base de données (`php bin/console doctrine:database:create`)
- Lancer la migration (`php bin/console doctrine:migrations:migrate`)
- Lancer le serveur (`symfony serve`)
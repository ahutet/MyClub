# Projet test Sportyma

#### 1 - Cloner le repository
 * git clone git@gitlab.com:ahutet/MyClub.git

#### 2 - Installer les dependances
  * composer install

#### 3 - Création et connection BDD
Copier/coller le contenu du .env dans .env.local et modifier la variable DATABASE_URL avec vous informations
  * php bin/console doctrine:database:create
  * php bin/console make:migration
  * php bin/console doctrine:migration:migrate

#### 4 - Insertion des données en BDD
  * php bin/console doctrine:fixtures:load

#### 5 - Lancer le projet
  * symfony server:start

#### 6 - Login de connexion
  * manager@manager.fr
  * manager


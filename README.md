Projet test Sportyma

1 - Cloner le repository
  git clone git@gitlab.com:

2 - Installer les dependances
  composer install

3 - Création et connection BDD
Copier/coller le contenu du .env dans .env.local et modifier la variable DATABASE_URL
  php bin/console doctrine:database:create
  php bin/console make:migration
  php bin/console doctrine:migration:migrate

4 - Insertion des données en BDD
  php bin/console doctrine:fixtures:load

5 - Lancer le projet
  symfony server:start


1 - Cloner le repository
git clone git@gitlab.com:baguette-box/baguette-box.git
cd baguette-box

2 - Installer les dependances
composer install

3 - Installation de node_modules
yarn

4 - Permissions
sudo mkdir public/build/
sudo mkdir public/media/cache/
sudo chmod -R 777 public/build/
sudo chmod -R 777 public/media/cache/
sudo chmod -R 777 var/log/

5 - Création et connection BDD
Copier/coller le contenu du .env dans .env.local et modifier la variable DATABASE_URL
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migration:migrate

6 - Insertion des données statique en BDD
php bin/console doctrine:fixtures:load --group=AddCitiesFixtures
php bin/console doctrine:fixtures:load --append --group=AddBakeryFixtures
php bin/console doctrine:fixtures:load --append --group=AddBakeryDeliveriesFixtures
php bin/console doctrine:fixtures:load --append --group=AddBakeryCategoriesFixtures
php bin/console doctrine:fixtures:load --append --group=AddBakeryArticlesFixtures
php bin/console doctrine:fixtures:load --append --group=AddUsersHeadFixtures
php bin/console doctrine:fixtures:load --append --group=AddToursFixtures
php bin/console doctrine:fixtures:load --append --group=AddCustomersFixtures
php bin/console doctrine:fixtures:load --append --group=AddCustomersStepsFixtures
php bin/console doctrine:fixtures:load --append --group=AddCustomersCommentsFixtures
php bin/console doctrine:fixtures:load --append --group=UpdateOrderTourFixtures
php bin/console doctrine:fixtures:load --append --group=AddCustomersTourFixtures
php bin/console doctrine:fixtures:load --append --group=AddOrdersFixtures
php bin/console doctrine:fixtures:load --append --group=AddHistoriqueFixtures
php bin/console doctrine:fixtures:load --append --group=AddLocationBoxFixtures
php bin/console doctrine:fixtures:load --append --group=AddOldOrdersFixtures
php bin/console doctrine:fixtures:load --append --group=AddSmsConfigFixtures

7 - Lets' GO
Compiler les css et les js pour le dev
yarn run encore dev --watch

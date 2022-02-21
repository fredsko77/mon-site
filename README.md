# Mon site Potoflio - Documentation

## Projet développé avec

 - Symfony 5.3.15
 - Bootstrap 5

## Prérequis

 - PHP >= 7.2.5 -> [Doc installation PHP](https://www.php.net/manual/fr/install.php)
 - Composer >= 1.8 -> [Doc installation de Composer](https://getcomposer.org/download/)
 - Symfony console (facultatif) -> [Doc installation de la console de Symfony](https://symfony.com/doc/current/components/console.html)

## Installation 

1. Clôner le projet 
```
git clone https://github.com/fredsko77/mon-site.git
```

2. Installer les dépendances de Symfony et les dépendances du projet
```
composer install
```

3. Générer le fichier .env
```
composer dump-env dev
```

4. Configurer les variables d'environnement dans le fichier .env 
    APP_ENV=dev
    APP_DEBUG=true
    DATABASE_URL=
    MAILER_DSN=  
    <br>

5. Générer la base de données et les migrations 

```
php bin/console doctrine:database:create (facultatif)
php bin/console make:migration 
php bin/console doctrine:migrations:migrate --no-interaction
```

6. Charger le jeu de données avec les Fixtures
```
php bin/console doctrine:fixtures:load --no-interaction
```

7. Installer les assets de CKEditor et ElFinder  
```
php bin/console ckeditor:install
php bin/console assets:install public/
php bin/console elfinder:install
php bin/console assets:install public/
```

Une fois que tout est installé vider le cache avec la commande 
```
php bin/console cache:clear
```     

C'est parti ! 🚀
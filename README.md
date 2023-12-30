# MyBooks

## Description
MyBooks est une application web pour gérer une collection de livres. Les utilisateurs peuvent ajouter des éditeurs dans la base de données, ajouter des livres, les lier à des éditeurs, et gérer les prêts.

## Spécification
La base de données fournie avec l'application MyBooks contient des données semi-randomisées pour faciliter les tests et les démonstrations.


## Technologies requises
- php: >=8.2
- symfony/http-foundation: ^7.0
- symfony/routing: ^7.0
- twig/twig: ^3.8
- doctrine/orm: ^2.17
- doctrine/dbal: ^3.7
- symfony/yaml: ^7.0
- symfony/cache: ^7.0
- symfony/validator: ^7.0
- monolog/monolog: ^3.5"

## Installation

### Prérequis
- Serveur PHP
- Composer pour gérer les dépendances PHP

### Étapes d'Installation
1. **Cloner le dépôt :**
```
git clone https://github.com/AlexisBCD/MyBooks/
cd MyBooks
```

2. **Installer les dépendances :**
```
composer install
```


3. **Mettre à jour la base de données :**
```
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

4. **Lancer l'application :**
- Héberger l'application sur un serveur PHP.
OU
- Lancer l'application en local avec 
```
php -S 127.0.0.1:8000 -t public
```
- Accéder à l'application via un navigateur web.

5. **Connexion à l'application :**
- Après avoir lancé l'application, il est important de se connecter pour accéder à toutes ses fonctionnalités. MyBooks dispose d'un système d’authentification. Pour les besoins des tests et de la démonstration, un compte utilisateur a été pré-configuré avec les identifiants suivants :

```
Nom d'utilisateur : test
```
```
Mot de passe : test
```

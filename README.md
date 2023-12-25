# MyBooks

## Description
MyBooks est une application web pour gérer une collection de livres. Les utilisateurs peuvent ajouter des éditeurs dans la base de données, ajouter des livres, les lier à des éditeurs, et gérer les prêts.

## Technologies Utilisées
- PHP
- Doctrine pour la gestion des données
- Authentification utilisateur
- Interface responsive (compatible avec mobile, tablette, ordinateur)
- Monolog pour l'enregistrement des actions des utilisateurs
- Webhook pour les notifications (ex: Discord)

## Installation

### Prérequis
- Serveur PHP
- Composer pour gérer les dépendances PHP

### Étapes d'Installation
1. **Cloner le dépôt :**
git clone https://github.com/AlexisBCD/MyBooks/
cd MyBooks


2. **Installer les dépendances :**
composer install


3. **Configurer la base de données :**
- Créer une base de données MySQL.
- Configurer les paramètres de connexion dans le fichier de configuration.

4. **Initialiser la base de données :**
- Exécuter les migrations pour créer les tables nécessaires.
- (Optionnel) Charger les jeux de données initiaux si disponibles.

5. **Configurer les services externes :**
- Si vous utilisez le Webhook pour Discord, configurez-le selon vos besoins.

6. **Lancer l'application :**
- Héberger l'application sur un serveur PHP.
- Accéder à l'application via un navigateur web.

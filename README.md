# Troc Mon Toit

Une plateforme pour la location de logements offrant une variété d'hébergements allant des appartements aux igloos, avec des fonctionnalités de filtrage avancées et un processus de réservation sécurisé.

## Description du Projet

L'application Troc Mon Toit vise à digitaliser les services de location d'une agence, offrant une sélection diversifiée de logements avec des fonctionnalités de recherche avancées. Les utilisateurs peuvent consulter les logements disponibles, filtrer par ville, type de logement, équipements et services, et effectuer des réservations sécurisées.

## Fonctionnalités Principales

- **Affichage des Logements :** Présentation des logements avec images, filtrables par ville, type, prix, équipements et services.
- **Favoris Utilisateur :** Possibilité pour les utilisateurs connectés d'ajouter des logements en favoris et d'accéder à cette liste.
- **Détails du Logement :** Affichage détaillé avec prix par nuit, commentaires et notes des locataires, disponibilités de réservation.
- **Réservations :** Les utilisateurs connectés peuvent réserver un logement en choisissant des dates cohérentes, calculant automatiquement le prix total et bloquant les réservations simultanées.
- **Notation des Logements :** Les utilisateurs peuvent laisser une évaluation après la fin du séjour.

## Éléments Spécifiques

- **Types de Logement :** CRUD pour gérer les différents types de logements.
- **Équipements et Services :** CRUD pour gérer les équipements et services disponibles pour les logements.
- **Gestion des Utilisateurs :** CRUD pour les données basiques des utilisateurs, historique des favoris, avis et réservations.
- **Panel Administratif :** Accès protégé par identification pour gérer les caractéristiques, avis, utilisateurs et disponibilités des logements.

## Technologies Utilisées

- **PHP :** Langage de programmation utilisé pour la logique back-end.
- **Twig :** Moteur de template utilisé pour générer les vues HTML.
- **.env :** Utilisé pour la gestion des variables d'environnement et la configuration.
- **Faker :** Outil utilisé pour générer des données aléatoires à des fins de test.
- **Makefile :** Utilisé pour automatiser des tâches courantes ou des scripts.
- **GitHub :** Plateforme de gestion de versions utilisée pour héberger le code source et collaborer sur le projet.



## Installation

### Depuis le Repo Git

Pour installer le projet depuis le repository Git, utilisez la commande suivante dans votre terminal :

```bash
git clone [https://github.com/nom_utilisateur/nom_projet.git](https://github.com/B2-Info-23-24/php-Doctorwho07.git)https://github.com/B2-Info-23-24/php-Doctorwho07.git
```

### Installation de Faker sous macOS et WSL

Veillez a bien choisir la version en fonction d'apache web

```
composer require fzaninotto/faker
```

### Installation de composer avec les fichiers de configuration

```
composer install
```

## Execution

### Initialisation Faker

Se rendre a la racine des fichiers, où se trouve docker-compose.yml

```
make faker
```

### Initialisation du Projet

Se rendre a la racine des fichiers, où se trouve docker-compose.yml

```
docker-compose up -d
```


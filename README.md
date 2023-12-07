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

- **Langages :** PHP
- **Outils :** Dotenv, Faker
- **Environnement :** Docker
- **Modèles :** Twig pour la génération de templates
- **Automatisation :** Makefile pour l'exécution de Faker

## Installation

Pour installer le projet, utilisez npm avec les commandes suivantes :

```bash
npm install my-project
cd my-project
```

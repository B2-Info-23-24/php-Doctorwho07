# Troc Mon Toit

A platform for housing rentals offering a variety of accommodations from apartments to igloos, with advanced filtering features and a secure reservation process.

## Project Description

The Troc Mon Toit application aims to digitize the rental services of an agency, offering a diverse selection of accommodations with advanced search functionalities. Users can view available lodgings, filter by city, type of lodging, amenities, and services, and make secure reservations.

## Key Features

- **Lodging Display:** Presentation of lodgings with images, filterable by city, type, price, amenities, and services.
- **User Favorites:** Ability for logged-in users to add lodgings to favorites and access this list.
- **Lodging Details:** Detailed view with price per night, tenant comments and ratings, reservation availability.
- **Reservations:** Logged-in users can book a lodging by choosing coherent dates, automatically calculating the total price, and preventing simultaneous reservations.
- **Lodging Reviews:** Users can leave a review after their stay.

## Specific Elements

- **Lodging Types:** CRUD to manage different lodging types.
- **Amenities and Services:** CRUD to manage available amenities and services for lodgings.
- **User Management:** CRUD for basic user data, favorites, reviews, and reservations.
- **Admin Panel:** Protected access for managing features, reviews, users, and lodging availabilities.

## Technologies Used

- **PHP:** Programming language used for backend logic.
- **Twig:** Template engine used to generate HTML views.
- **.env:** Used for managing environment variables and configuration.
- **Faker:** Tool used to generate random data for testing purposes.
- **Makefile:** Used to automate common tasks or scripts.
- **GitHub:** Version control platform used to host the source code and collaborate on the project.

## Installation

### From Git Repository

To install the project from the Git repository, use the following command in your terminal:

```
git clone [https://github.com/nom_utilisateur/nom_projet.git](https://github.com/B2-Info-23-24/php-Doctorwho07.git)https://github.com/B2-Info-23-24/php-Doctorwho07.git
```

###  Installing Faker on macOS and WSL

Ensure to choose the appropriate version based on the Apache web server

```
composer require fzaninotto/faker
```

### Composer Installation with Configuration Files

```
composer install
```

##  Execution

###  Faker Initialization

Navigate to the root directory, where the docker-compose.yml file is located

```
make faker
```

### Initialisation du Projet

Se rendre a la racine des fichiers, où se trouve docker-compose.yml

```
docker-compose up -d
```


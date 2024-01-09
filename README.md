# Troc Mon Toit

A platform for housing rentals offering a variety of accommodations from apartments to igloos, with advanced filtering features and a secure reservation process.

## Project Description

The Troc Mon Toit application aims to digitize the rental services of an agency, offering a diverse selection of accommodations with advanced search functionalities. Users can view available lodgings, filter by city, type of lodging, amenities, and services, and make secure reservations.

## Project Screenshot

<img width="1512" alt="Capture d’écran 2023-12-07 à 23 40 01" src="https://github.com/B2-Info-23-24/php-Doctorwho07/assets/112888518/230e78ce-985d-4da9-81fb-67955fa67293">
<img width="1512" alt="Capture d’écran 2023-12-07 à 23 41 17" src="https://github.com/B2-Info-23-24/php-Doctorwho07/assets/112888518/f5207e0d-4ff4-4b12-9c18-11481929f4ff">


## Key Features

- Lodging Display: Presentation of lodgings with images, filterable by city, type, price, amenities, and services.
- User Favorites: Ability for logged-in users to add lodgings to favorites and access this list.
- Lodging Details: Detailed view with price per night, tenant comments and ratings, reservation availability.
- Reservations: Logged-in users can book a lodging by choosing coherent dates, automatically calculating the total price, and preventing simultaneous reservations.
- Lodging Reviews: Users can leave a review after their stay.

## Specific Elements

- Lodging Types:** CRUD to manage different lodging types.
- Amenities and Services: CRUD to manage available amenities and services for lodgings.
- User Management: CRUD for basic user data, favorites, reviews, and reservations.
- Admin Panel: Protected access for managing features, reviews, users, and lodging availabilities.

## Technologies Used

- PHP: Programming language used for backend logic.
- Twig: Template engine used to generate HTML views.
- .env: Used for managing environment variables and configuration.
- Faker: Tool used to generate random data for testing purposes.
- Makefile: Used to automate common tasks or scripts.
- GitHub: Version control platform used to host the source code and collaborate on the project.

## Installation

### Prerequires

- Docker : https://www.docker.com
- Git : https://git-scm.com

### From Git Repository

To install the project from the Git repository, use the following command in your terminal:

Create a folder `alexis-php`

```
git clone [https://github.com/B2-Info-23-24/php-Doctorwho07.git]
```

### Rename the cloned folder into `src`. You can use the following command:
```
mv php-Doctorwho07 src
```

### Create a file .env to store the credentials to access the database and paste the following content:

```
nano src/.env
```
write this : 
```
DB_NAME=db_test
DB_USER=Docker
DB_PASSWORD=super-secure-password
DB_HOST=mysql
```
### Create a file `docker-compose.yml` inside the folder `alexis-php` (outside of `src` then) and paste the following content:

```
cd ..
nano docker-compose.yml
```
write this
```
version: "3"

services:
  web:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html

  mysql:
    image: mysql:latest
    platform: linux/x86_64
    environment:
      MYSQL_ROOT_PASSWORD: super-secure-password
      MYSQL_DATABASE: db_test
      MYSQL_USER: Docker
      MYSQL_PASSWORD: super-secure-password
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"
volumes:
  db_data:
```

### Create a file `Dockerfile` inside the folder `alexis-php` (outside of `src` then) and paste the following content:

```
nano Dockerfile
```
write this
```
FROM php:8.2-apache

RUN a2enmod rewrite

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

#Installer composer 
RUN apt-get update && \    
    apt-get install -y unzip && \     
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN service apache2 restart
RUN composer require vlucas/phpdotenv

# WORKDIR /var/www/html/ # RUN chmod -R 777 /var/www
# RUN pecl install xdebug \
#     && apt update \
#     && apt install libzip-dev -y \
#     && docker-php-ext-enable xdebug \
#     && a2enmod rewrite \
#     && docker-php-ext-install zip \
#     && service apache2 restart

# ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/.conf
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/.conf
```
### Create the docker container (the process can be long):
<br>⚠️ Be sure that Docker is running on your machine

```
docker-compose up -d
```

### Enter into the Docker container's command prompt:**
```
docker exec -it projetphp-web-1 /bin/bash
```

### Install the necessary packages by executing the following commands one by one:**
<br> If a message like "Continue as root/super user [yes]?" appears, enter "y" in the command prompt**
```bash
composer install
```
```bash
composer update
```
```bash
composer dump-autoload
```
```bash
exit
```

### Execute the following commands one by one to initialize the project:
```bash
cd src
make faker
```
These errors are not abnormal. They occur in the rare case when Faker generates redundant data, which creates database errors.

12. You can exit the docker container's command prompt:
```bash
exit
```

###  Project Initialization

Navigate to the root directory, where the docker-compose.yml file is located

```
docker-compose up -d
```

###  Project Configuration (if necessary)

Navigate to Beekeeper after connecting to the database

```
INSERT INTO services (Type) VALUES ('Transferts aéroport'),('Petit-déjeuner'),('Service de ménage'),('Location de voiture'),('Visites guidées'),('Cours de cuisine'),('Loisirs');
INSERT INTO lodging_types (Type) VALUES ('Appartements'),('Maisons'),('Chalets'),('Villas'),('Péniches'),('Yourtes'),('Cabanes'),('Igloos'),('Tentes'),('Cars');
INSERT INTO equipments (Type) VALUES ('Connexion Wi-Fi'),('Climatiseur'),('Chauffage'),('Machine à laver'),('Sèche-linge'),('Télévision'),('Fer à repasser / Planche à repasser'),('Nintendo Switch'),('PS5'),('Terrasse'),('Balcon'),('Piscine'),('Jardin');
```
### Open your navigator and go to http://localhost:8080
<br>To access the administrator panel, you can use the following account:
<br>- Email : `admin@admin.com`
<br>- Password : `admin`


## Authors

- [@DoctorWho](https://github.com/Doctorwho07)


<?php

namespace Models;

class InitDB
{
    static function InitDB()
    {
        $connexion = ConnectDB::getConnection();


        $connexion->exec("CREATE TABLE IF NOT EXISTS services (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");
        // $connexion->exec("INSERT INTO services (Type) VALUES 
        //     ('Transferts aéroport'),
        //     ('Petit-déjeuner'),
        //     ('Service de ménage'),
        //     ('Location de voiture'),
        //     ('Visites guidées'),
        //     ('Cours de cuisine'),
        //     ('Loisirs');
        //     ");

        $connexion->exec("CREATE TABLE IF NOT EXISTS lodging_types (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");
        // $connexion->exec("INSERT INTO lodging_types (Type) VALUES 
        //     ('Appartements'),
        //     ('Maisons'),
        //     ('Chalets'),
        //     ('Villas'),
        //     ('Péniches'),
        //     ('Yourtes'),
        //     ('Cabanes'),
        //     ('Igloos'),
        //     ('Tentes'),
        //     ('Cars');");

        $connexion->exec("CREATE TABLE IF NOT EXISTS equipments (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");
        // $connexion->exec("INSERT INTO equipments (Type) VALUES 
        //     ('Connexion Wi-Fi'),
        //     ('Climatiseur'),
        //     ('Chauffage'),
        //     ('Machine à laver'),
        //     ('Sèche-linge'),
        //     ('Télévision'),
        //     ('Fer à repasser / Planche à repasser'),
        //     ('Nintendo Switch'),
        //     ('PS5'),
        //     ('Terrasse'),
        //     ('Balcon'),
        //     ('Piscine'),
        //     ('Jardin');
        //     ");

        $connexion->exec("CREATE TABLE IF NOT EXISTS properties (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Title VARCHAR(255),
            Description VARCHAR(255),
            Image VARCHAR(255),
            Price INT,
            Location VARCHAR(255),
            City VARCHAR(50),
            foreign_key_lodging_type INT,
            FOREIGN KEY (foreign_key_lodging_type) REFERENCES lodging_types(id) ON DELETE CASCADE)");

        $connexion->exec("CREATE TABLE IF NOT EXISTS users (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Lastname VARCHAR(255),
            Firstname VARCHAR(255),
            Phone VARCHAR(255) UNIQUE,
            Email VARCHAR(255) UNIQUE,
            IsAdmin BOOLEAN,
            Password VARCHAR(255))");

        $connexion->exec("CREATE TABLE IF NOT EXISTS orders (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Start DATE,
            End DATE,
            DateOrder DATE,
            Price INT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(id) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(id) ON DELETE CASCADE)");

        $connexion->exec("CREATE TABLE IF NOT EXISTS favorites (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(id) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(id) ON DELETE CASCADE)");

        $connexion->exec("CREATE TABLE IF NOT EXISTS reviews (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Title VARCHAR(255),
            Comment VARCHAR(255),
            Rating INT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(id) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(id) ON DELETE CASCADE)");

        $connexion->exec("CREATE TABLE IF NOT EXISTS selected_equipments (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(id) ON DELETE CASCADE,
            foreign_key_equipments INT,
            FOREIGN KEY (foreign_key_equipments) REFERENCES equipments(id) ON DELETE CASCADE)");

        $connexion->exec("CREATE TABLE IF NOT EXISTS selected_services (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(id) ON DELETE CASCADE,
            foreign_key_services INT,
            FOREIGN KEY (foreign_key_services) REFERENCES services(id) ON DELETE CASCADE)");
    }
}

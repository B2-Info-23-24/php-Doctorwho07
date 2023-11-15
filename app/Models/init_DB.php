<?php

require_once "connexion_DB.php";

function InitDB()
{
    $connexion = ConnectDB();

    $connexion->exec("CREATE TABLE IF NOT EXISTS services (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Type VARCHAR(255))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS lodging_types (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Type VARCHAR(255))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS amenities (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Type VARCHAR(255))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS properties (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Title VARCHAR(255),
        Description VARCHAR(255),
        Image VARCHAR(255),
        Price INT,
        Location VARCHAR(255),
        foreign_key_lodging_type INT,
        FOREIGN KEY (foreign_key_lodging_type) REFERENCES lodging_types(id))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS users (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Lastname VARCHAR(255),
        Firstname VARCHAR(255),
        Email VARCHAR(255),
        IsAdmin BOOLEAN,
        Password VARCHAR(255))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS orders (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Start DATE,
        End DATE,
        Price INT,
        foreign_key_property INT,
        FOREIGN KEY (foreign_key_property) REFERENCES properties(id),
        foreign_key_user INT,
        FOREIGN KEY (foreign_key_user) REFERENCES users(id))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS favorites (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        foreign_key_property INT,
        FOREIGN KEY (foreign_key_property) REFERENCES properties(id),
        foreign_key_user INT,
        FOREIGN KEY (foreign_key_user) REFERENCES users(id))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS reviews (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Title VARCHAR(255),
        Comment VARCHAR(255),
        Rating INT,
        foreign_key_property INT,
        FOREIGN KEY (foreign_key_property) REFERENCES properties(id),
        foreign_key_user INT,
        FOREIGN KEY (foreign_key_user) REFERENCES users(id))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS selected_amenities (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        foreign_key_property INT,
        FOREIGN KEY (foreign_key_property) REFERENCES properties(id),
        foreign_key_user INT,
        FOREIGN KEY (foreign_key_user) REFERENCES users(id))");

    $connexion->exec("CREATE TABLE IF NOT EXISTS selected_services (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        foreign_key_property INT,
        FOREIGN KEY (foreign_key_property) REFERENCES properties(id),
        foreign_key_user INT,
        FOREIGN KEY (foreign_key_user) REFERENCES users(id))");
};
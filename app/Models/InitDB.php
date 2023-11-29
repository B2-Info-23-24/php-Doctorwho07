<?php

namespace Models;

class InitDB
{
    static function InitDB()
    {
        $connexion = ConnectDB::getConnection();

        //_________________ Table 'services' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS services (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");

        //_________________ Table 'lodging_types' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS lodging_types (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");

        //_________________ Table 'equipments' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS equipments (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Type VARCHAR(255))");

        //_________________ Table 'properties' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS properties (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Title VARCHAR(255),
            Description VARCHAR(255),
            Image VARCHAR(255),
            Price INT,
            Location VARCHAR(255),
            City VARCHAR(50),
            foreign_key_lodging_type INT,
            FOREIGN KEY (foreign_key_lodging_type) REFERENCES lodging_types(ID) ON DELETE CASCADE)");

        //_________________ Table 'users' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS users (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Lastname VARCHAR(255),
            Firstname VARCHAR(255),
            Phone VARCHAR(255) UNIQUE,
            Email VARCHAR(255) UNIQUE,
            IsAdmin BOOLEAN,
            Password VARCHAR(255))");

        //_________________ Table 'orders' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS orders (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Start DATE,
            End DATE,
            DateOrder DATE,
            Price INT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(ID) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(ID) ON DELETE CASCADE)");

        //_________________ Table 'favorites' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS favorites (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(ID) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(ID) ON DELETE CASCADE)");

        //_________________ Table 'reviews' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS reviews (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            Title VARCHAR(255),
            Comment VARCHAR(255),
            Rating INT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(ID) ON DELETE CASCADE,
            foreign_key_user INT,
            FOREIGN KEY (foreign_key_user) REFERENCES users(ID) ON DELETE CASCADE)");

        //_________________ Table 'selected_equipments' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS selected_equipments (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(ID) ON DELETE CASCADE,
            foreign_key_equipments INT,
            FOREIGN KEY (foreign_key_equipments) REFERENCES equipments(ID) ON DELETE CASCADE)");

        //_________________ Table 'selected_services' _________________//
        $connexion->exec("CREATE TABLE IF NOT EXISTS selected_services (
            ID INT PRIMARY KEY AUTO_INCREMENT,
            foreign_key_property INT,
            FOREIGN KEY (foreign_key_property) REFERENCES properties(ID) ON DELETE CASCADE,
            foreign_key_services INT,
            FOREIGN KEY (foreign_key_services) REFERENCES services(ID) ON DELETE CASCADE)");
    }
}

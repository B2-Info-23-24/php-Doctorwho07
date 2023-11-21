<?php

namespace Models;

use PDOException, PDO;

class ReviewsModel
{
    static function getAllReviews()
    {
        $connexion = ConnectDB();
        try {
            $sql = "SELECT * FROM reviews";
            $reviewsList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $reviewsList !== false ? $reviewsList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }

    static function AddReviews($Title, $Comment, $Rating)
    {
        $connexion = ConnectDB();
        try {
            $sql = "INSERT INTO reviews (Title, Comment, Rating, foreign_key_property, foreign_key_user) VALUES ('$Title', '$Comment', '$Rating', NULL, NULL)";
            $connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    static function DeleteReviews($ID)
    {
        $connexion = ConnectDB();
        try {
            $sql = "DELETE FROM reviews WHERE ID = '$ID'";
            $connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    static function GetReviewsById($reviewsId)
    {
        $connexion = ConnectDB();
        try {
            $sql = "SELECT * FROM users WHERE ID = '$reviewsId'";
            $userData = $connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
}

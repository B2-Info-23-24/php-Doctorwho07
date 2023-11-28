<?php

namespace Models;

use PDOException, PDO;

class ReviewsModel
{
    static function getAllReviews()
    {
        $connexion = ConnectDB::getConnection();
        try {
            $sql = "SELECT * FROM reviews";
            $reviewsList = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $reviewsList !== false ? $reviewsList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }
    static function addReview($userId, $propertyId, $title, $comment, $rating)
    {
        $connexion = ConnectDB::getConnection();

        try {
            $sql = "INSERT INTO reviews (Title, Comment, Rating, foreign_key_property, foreign_key_user) VALUES (?, ?, ?, ?, ?)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([$title, $comment, $rating, $propertyId, $userId]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'avis : " . $e->getMessage();
            return false;
        }
    }

    static function DeleteReviews($ID)
    {
        $connexion = ConnectDB::getConnection();

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
        $connexion = ConnectDB::getConnection();

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

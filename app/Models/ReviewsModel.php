<?php
class ReviewsModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = ConnectDB();
    }

    public function getAllReviews()
    {
        try {
            $sql = "SELECT * FROM reviews";
            $reviewsList = $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $reviewsList !== false ? $reviewsList : array();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des types de services : " . $e->getMessage();
            return [];
        }
    }

    public function AddReviews($Title, $Comment, $Rating)
    {
        try {
            $sql = "INSERT INTO reviews (Title, Comment, Rating, foreign_key_property, foreign_key_user) VALUES ('$Title', '$Comment', '$Rating', NULL, NULL)";
            $this->connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    public function DeleteReviews($ID)
    {
        try {
            $sql = "DELETE FROM reviews WHERE ID = '$ID'";
            $this->connexion->exec($sql);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    public function GetReviewsById($reviewsId)
    {
        try {
            $sql = "SELECT * FROM users WHERE ID = '$reviewsId'";
            $userData = $this->connexion->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $userData !== false ? $userData : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }
}

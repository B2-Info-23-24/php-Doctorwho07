<?php

namespace Models;

use PDOException, PDO;

class ReviewsModel
{
    static function getAllReviews()
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM reviews";
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function getReviewsForProperty($propertyId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM reviews WHERE foreign_key_property = ?";
        $query = $db->prepare($sql);
        $query->execute([$propertyId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function addReview($userId, $propertyId, $title, $comment, $rating)
    {
        $db = ConnectDB::getConnection();
        $sql = "INSERT INTO reviews (Title, Comment, Rating, foreign_key_property, foreign_key_user) VALUES (?, ?, ?, ?, ?)";
        $query = $db->prepare($sql);
        return $query->execute([$title, $comment, $rating, $propertyId, $userId]);
    }
    static function DeleteReviews($ID)
    {
        $db = ConnectDB::getConnection();
        $sql = "DELETE FROM reviews WHERE ID = ?";
        $query = $db->prepare($sql);
        return $query->execute([$ID]);
    }
    static function GetReviewsById($reviewsId)
    {
        $db = ConnectDB::getConnection();
        $sql = "SELECT * FROM users WHERE ID = ?";
        $query = $db->prepare($sql);
        $query->execute([$reviewsId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public static function updateReview($reviewId, $title, $comment, $rating, $userId)
    {
        // var_dump("review" . $reviewId, "title" . $title, "comment" . $comment, "rating" . $rating, "userid" . $userId);
        $db = ConnectDB::getConnection();
        $sql = "UPDATE reviews SET Title = ?, Comment = ?, Rating = ? WHERE ID = ? AND foreign_key_user = ?";
        $query = $db->prepare($sql);
        return $query->execute([$title, $comment, $rating, $reviewId, $userId]);
    }
    public static function getAllReviewsByUser($userId)
    {
        $connexion = ConnectDB::getConnection();
        $query = "SELECT r.*, p.Title AS PropertyTitle
              FROM reviews r
              INNER JOIN properties p ON r.foreign_key_property = p.ID
              WHERE r.foreign_key_user = :userId";
        $statement = $connexion->prepare($query);
        $statement->bindParam(':userId', $userId);
        $statement->execute();
        $reviews = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $reviews;
    }
    public static function getAveragePropertyRating()
    {
        $connexion = ConnectDB::getConnection();
        $query = "SELECT AVG(Rating) AS AverageRating FROM reviews";
        $statement = $connexion->prepare($query);
        $statement->execute();
        $averageRating = $statement->fetch(PDO::FETCH_ASSOC);

        return $averageRating['AverageRating'];
    }
    public static function getAveragePropertyRatings()
    {
        $connexion = ConnectDB::getConnection();
        $query = "SELECT foreign_key_property, AVG(Rating) AS AverageRating
              FROM reviews
              GROUP BY foreign_key_property";
        $statement = $connexion->prepare($query);
        $statement->execute();
        $averageRatings = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $averageRatings;
    }
}

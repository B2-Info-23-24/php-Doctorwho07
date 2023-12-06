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
        $db = ConnectDB::getConnection();
        $sql = "UPDATE reviews SET Title = ?, Comment = ?, Rating = ? WHERE ID = ? AND foreign_key_user = ?";
        $query = $db->prepare($sql);
        return $query->execute([$title, $comment, $rating, $reviewId, $userId]);
    }
}

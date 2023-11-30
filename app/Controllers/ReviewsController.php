<?php

namespace Controllers;

use Models\ReviewsModel;

class ReviewsController
{
    public function publishReview()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['ID'];
        $propertyId = $_POST['propertyId'] ?? null;
        $title = $_POST['Title'] ?? '';
        $comment = $_POST['Comment'] ?? '';
        $rating = $_POST['Rating'] ?? 0;

        ReviewsModel::addReview($userId, $propertyId, $title, $comment, $rating);
        header("Location: /property/$propertyId");
        exit();
    }
}

<?php

namespace Controllers;

use Models\ReviewsModel, Models\UserModel, Models\PropertiesModel;


class ReviewsController
{
    public function index()
    {
        $reviews = ReviewsModel::getAllReviews();
        $allUserEmails = UserModel::getAllUserEmails();
        $allProperties = PropertiesModel::GetAllProperties();
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminReviews.html.twig');
        echo $template->display(
            [
                'title' => "Tous les avis",
                'reviews' => $reviews,
                'allUserEmails' => $allUserEmails,
                'allProperties' => $allProperties,
            ]
        );
    }
    public function publishReview()
    {
        $userId = $_SESSION['user']['ID'];
        $propertyId = intval($_POST['propertyId']) ?? null;
        $title = $_POST['Title'] ?? '';
        $comment = $_POST['Comment'] ?? '';
        $rating = $_POST['Rating'] ?? 0;
        ReviewsModel::addReview($userId, $propertyId, $title, $comment, $rating);
        header("Location: /orders");
        exit();
    }
    public function publishReviewAdmin()
    {
        $email = $_POST['Author'] ?? null;
        $propertyId = intval($_POST['propertyId']) ?? null;
        $title = $_POST['Title'] ?? '';
        $comment = $_POST['Comment'] ?? '';
        $rating = $_POST['Rating'] ?? 0;
        $userId = UserModel::GetUserIdByEmail($email);
        ReviewsModel::addReview($userId, $propertyId, $title, $comment, $rating);
        header("Location: /admin/reviews");
        exit();
    }
    public function deleteReview($reviewId)
    {
        $success = ReviewsModel::DeleteReviews($reviewId);

        if ($success) {
            header("Location: /admin/reviews");
            exit();
        } else {
            echo "Échec de la suppression de l'avis.";
        }
    }
    public function updateReview()
    {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'Title_') !== false) {
                $reviewId = substr($key, strpos($key, '_') + 1);
                $title = $_POST['Title_' . $reviewId];
                $email = $_POST['Author_' . $reviewId];
                $comment = $_POST['Comment_' . $reviewId];
                $rating = $_POST['Rating_' . $reviewId];
                $userId = UserModel::GetUserIdByEmail($email);
                $success = ReviewsModel::updateReview($reviewId, $title, $comment, $rating, $userId);

                if (!$success) {
                    echo "Échec de la mise à jour de l'avis avec ID : $reviewId";
                }
            }
        }
        header("Location: /admin/reviews");
        exit();
    }
}

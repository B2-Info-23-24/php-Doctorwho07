<?php

namespace Controllers;

use Models\ReviewsModel;

class ReviewsController
{
    public function index()
    {
        $reviews = ReviewsModel::getAllReviews();
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminReviews.html.twig');
        echo $template->display(
            [
                'title' => "Tous les avis",
                'reviews' => $reviews,
            ]
        );
    }
    public function publishReview()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user']['ID'];
        $propertyId = intval($_POST['propertyId']) ?? null;
        $title = $_POST['Title'] ?? '';
        $comment = $_POST['Comment'] ?? '';
        $rating = $_POST['Rating'] ?? 0;

        ReviewsModel::addReview($userId, $propertyId, $title, $comment, $rating);
        header("Location: /orders");
        exit();
    }
}

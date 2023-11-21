<?php

namespace Controllers;

use Models\UserModel;

class UserController
{
    static function showUser($userId)
    {
        $user = UserModel::GetUserById($userId);

        if ($user) {
            require_once(dirname(__DIR__) . '/Views/user_details.php');
        } else {
            header('Location: /');
            exit();
        }
    }
    static function extractuserId($route)
    {
        $parts = explode('/', $route);
        return end($parts);
    }
    static function Disconnect()
    {
        session_destroy();
        header('Location: /');
    }
    static function Delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            UserModel::DeleteUser($email, $password);
            UserController::Disconnect();
            header('Location: /');
        } else {
            header('Location: inscription');
            exit();
        }
    }
}

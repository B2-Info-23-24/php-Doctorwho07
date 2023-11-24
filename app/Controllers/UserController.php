<?php

namespace Controllers;

use Models\UserModel;

class UserController
{
    static public function home()
    {
        $Lastname = $_SESSION['user']['Lastname'];
        $Firstname = $_SESSION['user']['Firstname'];
        $Phone = $_SESSION['user']['Phone'];
        $Email = $_SESSION['user']['Email'];
        $IsAdmin = $_SESSION['user']['IsAdmin'];
        $Password = $_SESSION['user']['Password'];
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/UserPanel.html.twig');
        echo $template->display(
            [
                'title' => "Panel Utilisateur",
                'Lastname' => $Lastname,
                'Firstname' => $Firstname,
                'Phone' =>  $Phone,
                'Email' =>  $Email,
                'IsAdmin' =>  $IsAdmin,
                'Password' =>  $Password,
            ]
        );
    }
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
        unset($_SESSION['user']);
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
    public static function modify()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /connexion");
            exit;
        }
        $olddata = $_SESSION['user'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUserData = [
                'ID' => $_SESSION['user']['ID'],
                'lastname' => $_POST['lastname'],
                'firstname' => $_POST['firstname'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'IsAdmin' => $_SESSION['user']['IsAdmin'],
                'password' => $_POST['password'],
            ];

            if (UserModel::updateUserById($newUserData)) {
                $_SESSION['user']['Lastname'] = $newUserData['lastname'];
                $_SESSION['user']['Firstname'] = $newUserData['firstname'];
                $_SESSION['user']['Phone'] = intval($newUserData['phone']);
                $_SESSION['user']['Email'] = $newUserData['email'];
                $_SESSION['user']['IsAdmin'] = $newUserData['IsAdmin'];
                $_SESSION['user']['Password'] = $newUserData['password'];

                header("Location: /user");
                exit;
            } else {
                header("Location: /modify");
                // Gérer l'échec de la mise à jour (redirection ou message d'erreur)
            }
        }
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AccountModify.html.twig');
        echo $template->display(
            [
                'title' => "Panel Utilisateur",
                'Lastname' => $olddata['Lastname'],
                'Firstname' => $olddata['Firstname'],
                'Phone' =>  $olddata['Phone'],
                'Email' =>  $olddata['Email'],
                'IsAdmin' =>  $olddata['IsAdmin'],
                'Password' =>  $olddata['Password'],
            ]
        );
    }
}

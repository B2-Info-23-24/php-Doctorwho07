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
                'Password' =>  $Password,
                'admin' => $IsAdmin,
            ]
        );
    }
    static function showUser($userId)
    {
        $user = UserModel::GetUserById($userId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/UserPanel.html.twig');
        echo $template->render([
            'title' => "Informations utilisateur",
            'ID' => $user['ID'],
            'Lastname' => $user['Lastname'],
            'Firstname' => $user['Firstname'],
            'Phone' => $user['Phone'],
            'Email' => $user['Email'],
            'IsAdmin' => $user['IsAdmin'],
            'Password' => $user['Password'],
        ]);
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
            header('Location: register');
            exit();
        }
    }
    public static function modify()
    {
        $userId = intval($_SESSION['user']['ID']);
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
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
                'confirmPassword' => $_POST['confirmPassword']
            ];
            if (UserModel::updateUserById($userId, $newUserData)) {
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
            }
        }

        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AccountModify.html.twig');
        echo $template->display(
            [
                'title' => "Panel Utilisateur",
                'ID' => $olddata['ID'],
                'Lastname' => $olddata['Lastname'],
                'Firstname' => $olddata['Firstname'],
                'Phone' =>  $olddata['Phone'],
                'Email' =>  $olddata['Email'],
                'IsAdmin' =>  $olddata['IsAdmin'],
                'Password' =>  $olddata['Password'],
            ]
        );
    }
    public function modifyUser($userId)
    {
        $user = UserModel::GetUserById($userId);
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AccountModify.html.twig');

        echo $template->render([
            'title' => "Modifier l'utilisateur",
            'user' => $user,
        ]);
    }

    public function updateUser()
    {
        $userId = $_POST['userId'];
        $lastname = $_POST['Lastname'];
        $firstname = $_POST['Firstname'];
        $phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $password = $_POST['Password'];

        UserModel::UpdateUserById($userId, [
            'Lastname' => $lastname,
            'Firstname' => $firstname,
            'Phone' => $phone,
            'Email' => $email,
            'Password' => $password,
        ]);
        header("Location: /user");
        exit();
    }
}

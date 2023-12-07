<?php

namespace Controllers;

use Models\PropertiesModel, Models\AdminModel, Models\UserModel;

class AdminPanelController
{
    public function home()
    {
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminPanel.html.twig');
        echo $template->display(
            [
                'title' => "Panneau d'administration",
                'admin' => $admin,
            ]
        );
    }
    public function users()
    {
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminUser.html.twig');
        echo $template->display(
            [
                'title' => "Utilisateurs",
                'users' => UserModel::GetAllUsers(),
                'admin' => $admin,
            ]
        );
    }
    public function properties()
    {
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminProperties.html.twig');
        echo $template->display(
            [
                'title' => "Logements",
                'properties' => PropertiesModel::GetAllProperties(),
                'admin' => $admin,
            ]
        );
    }
    public function admin()
    {
        $admin = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminAdmin.html.twig');
        echo $template->display(
            [
                'title' => "Administrateurs",
                'users' => UserModel::GetAllUsers(),
                'admin' => $admin,
            ]
        );
    }
    public function grantAdminRole()
    {
        $userID = intval($_POST['userID'] ?? 0);

        AdminModel::grantAdminRole($userID);
        header("Location: /admin/admin");
        exit();
    }

    public function revokeAdminRole()
    {
        $userID = intval($_POST['userID'] ?? 0);
        AdminModel::revokeAdminRole($userID);
        header("Location: /admin/admin");
        exit();
    }
    public function deleteUsers()
    {
        $userIDs = $_POST['userIDs'];
        foreach ($userIDs as $userID) {
            UserModel::DeleteUserById($userID);
        }
        header("Location: /admin/users");
        exit();
    }
    public function deleteProperty()
    {
        $propertiesIDs = $_POST['propertiesIDs'];
        foreach ($propertiesIDs as $userID) {
            PropertiesModel::DeletePropertiesById($userID);
        }
        header("Location: /admin/properties");
        exit();
    }
    public function AddUser()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/addUser.html.twig');
        echo $template->display(
            [
                'title' => "Ajouter un utilisateur",
            ]
        );
    }
}

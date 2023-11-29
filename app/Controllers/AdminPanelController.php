<?php

namespace Controllers;

use Models\PropertiesModel, Models\AdminModel, Models\UserModel;

class AdminPanelController
{
    public function home()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminPanel.html.twig');
        echo $template->display(
            [
                'Title' => "Panneau d'administration",
            ]
        );
    }
    public function users()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminUser.html.twig');
        echo $template->display(
            [
                'title' => "Home",
                'users' => UserModel::GetAllUsers(),
            ]
        );
    }
    public function properties()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminProperties.html.twig');
        echo $template->display(
            [
                'title' => "Home",
                'properties' => PropertiesModel::GetAllProperties(),
            ]
        );
    }
    public function admin()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/AdminAdmin.html.twig');
        echo $template->display(
            [
                'title' => "Home",
                'users' => UserModel::GetAllUsers(),
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userIDs'])) {
            $userIDs = $_POST['userIDs'];
            foreach ($userIDs as $userID) {
                UserModel::DeleteUserById($userID);
            }
            // Rediriger vers la page admin ou une autre page après la suppression
            header("Location: /admin/users");
            exit();
        } else {
            // Gérer le cas où rien n'est coché ou aucune donnée n'est transmise
            // Peut-être afficher un message d'erreur
        }
    }
    public function deleteProperty()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['propertiesIDs'])) {
            $propertiesIDs = $_POST['propertiesIDs'];
            foreach ($propertiesIDs as $userID) {
                PropertiesModel::DeletePropertiesById($userID);
            }
            header("Location: /admin/properties");
            exit();
        } else {
            // Gérer le cas où rien n'est coché ou aucune donnée n'est transmise
            // Peut-être afficher un message d'erreur
        }
    }
    public function AddUser()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/addUser.html.twig');
        echo $template->display();
    }
}
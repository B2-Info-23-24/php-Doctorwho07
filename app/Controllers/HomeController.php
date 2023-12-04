<?php

namespace Controllers;

use Models\PropertiesModel;
use Models\UserModel;
use Models\FavoriteModel;
use Controllers\LoginController;
use Models\PropertiesTypeModel;
use Models\FilterModel;

class HomeController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $minPrice = $_POST['minprice'] > 0 ? $_POST['minprice'] : null;
            $maxPrice = $_POST['maxprice'] > 0 ? $_POST['maxprice'] : null;
            $location = $_POST['PropertyCity'] != 0 ? $_POST['PropertyCity'] : null;
            $propertyType = $_POST['PropertyType'] != 0 ? $_POST['PropertyType'] : null;
            $selectedEquipments = isset($_POST['equipment']) ? $_POST['equipment'] : [];
            $selectedServices = isset($_POST['services']) ? $_POST['services'] : [];
            $filteredProperties = FilterModel::getFilteredProperties($minPrice, $maxPrice, $location, $propertyType, $selectedEquipments, $selectedServices);

            $property = $filteredProperties;
        } else {
            $property = PropertiesModel::GetAllProperties();
        }
        $loader = new \Twig\Loader\FilesystemLoader('App/Views/');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('pages/Home.html.twig');

        $users = isset($_SESSION['user']) ? UserModel::getAllUsers() : 0;
        $user = isset($_SESSION['user']) ? $_SESSION['user']['IsAdmin'] : 0;
        $connected = LoginController::isConnected();
        $propertiesTypes = PropertiesTypeModel::getAllPropertiesType();
        $propertiesEquipments = PropertiesModel::getAllEquipments();
        $propertiesServices = PropertiesModel::getAllServices();
        $propertiesCity = PropertiesModel::getAllUniqueCities();

        $propertiesandfavorites = [];
        foreach ($property as $property) {
            $isFavorite = isset($_SESSION['user']) ? FavoriteModel::isPropertyFavoritedByUser($_SESSION['user']['ID'], $property['ID']) : false;
            $accommodationAndFavorite = array('isFavorite' => $isFavorite) + $property;
            array_push($propertiesandfavorites, $accommodationAndFavorite);
        }

        echo $template->display([
            'title' => "Home",
            'properties' => $propertiesandfavorites,
            'users' => $users,
            'user' => $user,
            'connected' => $connected,
            'propertiesTypes' => $propertiesTypes,
            'propertiesEquipments' => $propertiesEquipments,
            'propertiesServices' => $propertiesServices,
            'propertiesCity' => $propertiesCity,
        ]);
    }
    public static function info()
    {
        phpinfo();
    }
}

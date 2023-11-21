<?php

namespace Controllers;

use Models\PropertiesModel;

class SearchController
{

    static function index()
    {
        require_once(dirname(__DIR__) . '/Views/search.php');
    }

    static function traitement()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $search = $_POST['search'];
            $searchResults = PropertiesModel::SearchProperties($search);

            $output = '<ul>';
            foreach ($searchResults as $result) {
                $output .= '<li data-property-id="' . $result['ID'] . '">' . $result['Title'] . '</li>';
            }
            $output .= '</ul>';

            echo $output;
        } else {
            header('Location: search');
            exit();
        }
    }
}

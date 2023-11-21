<?php

namespace Controllers;

class AccueilController
{
    public function index()
    {
        require_once(dirname(__DIR__) . '/Views/Accueil.php');
    }
}

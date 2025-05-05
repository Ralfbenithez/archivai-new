<?php
// /controllers/HomeController.php

class HomeController
{
    public function index()
    {
        // Charger le modèle si nécessaire
        require_once '../models/HomeModel.php';
        $homeModel = new HomeModel();

        // Récupérer les données nécessaires (exemple : titres, descriptions)
        $data = $homeModel->getData();

        // Charger la vue et passer les données
        require_once '../views/home.php';
    }
}

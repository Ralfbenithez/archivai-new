<?php
// Démarrer la session si nécessaire
session_start();

// Charger les fichiers de config
require_once '../config/config.php';

// Récupérer la route demandée
$route = $_GET['route'] ?? 'home';

// Chargement dynamique du contrôleur selon la route
switch ($route) {
   
    case 'home':
    default:
        require_once '../controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
}


<?php
// Outils de base
require_once __DIR__ . '/../App/Core/Router.php';
require_once __DIR__ . '/../App/Core/View.php';
require_once __DIR__ . '/../App/Core/Database.php'; 

// Modèles et Repositories
require_once __DIR__ . '/../App/Models/Employe.php'; 
require_once __DIR__ . '/../App/Repositories/EmployeRepository.php'; 

// Contrôleurs
require_once __DIR__ . '/../App/Controllers/DashboardController.php';

// Initialisation et exécution du Routeur

// On crée une instance du Routeur
$router = new Router();
//  On définit nos routes autorisées (l'annuaire)
// Ici, on dit : "Si on demande l'URL '/', appelle la méthode 'index' du DashboardController"
$router->get('/', [DashboardController::class, 'index']);
// Lance le moteur du Routeur en lui donnant l'URL demandée par le navigateur
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
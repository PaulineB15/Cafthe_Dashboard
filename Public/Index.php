
<?php


// Fonction = Connexion/session pour l'authentification + inactivité 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timeout de session après 30 minutes d'inactivité (30 * 60 = 1800 secondes)
$dureeMaxInactivite = 1800;

if (isset($_SESSION['employe']) && isset($_SESSION['dernier_acces'])) {
    if ((time() - $_SESSION['dernier_acces']) > $dureeMaxInactivite) {
        // Session expirée : on vide et détruit la session
        session_unset();
        session_destroy();
        header('Location: /Cafthe_Dashboard/Public/login');
        exit;
    }
}

// Met à jour le timestamp de dernière activité si un employé est connecté
if (isset($_SESSION['employe'])) {
    $_SESSION['dernier_acces'] = time();
}

// Protection des routes : redirection vers /login si non connecté
$cheminActuel = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$cheminActuel = str_replace('/Cafthe_Dashboard/Public', '', $cheminActuel);
if ($cheminActuel === '') {
    $cheminActuel = '/';
}

if (!isset($_SESSION['employe']) && $cheminActuel !== '/login') {
    header('Location: /Cafthe_Dashboard/Public/login');
    exit;
}

// Outils de base
require_once __DIR__ . '/../App/Core/Router.php';
require_once __DIR__ . '/../App/Core/View.php';
require_once __DIR__ . '/../App/Core/Database.php'; 

// Modèles et Repositories
require_once __DIR__ . '/../App/Models/Employe.php'; 
require_once __DIR__ . '/../App/Repositories/EmployeRepository.php';
require_once __DIR__ . '/../App/Models/Produit.php'; 
require_once __DIR__ . '/../App/Repositories/ProduitRepository.php'; 

// Contrôleurs
require_once __DIR__ . '/../App/Controllers/DashboardController.php';
require_once __DIR__ . '/../App/Controllers/ProduitController.php';
require_once __DIR__ . '/../App/Controllers/AuthController.php';
require_once __DIR__ . '/../App/Controllers/ProfilController.php';


// Initialisation et exécution du Routeur

// Créer une instance du Routeur
$router = new Router();
//  Définit les routes autorisées (l'annuaire)

// Ici, on dit : "Si on demande l'URL '/', appelle la méthode 'index' du DashboardController"
$router->get('/', [DashboardController::class, 'index']);

$router->get('/produits', [ProduitController::class, 'index']);

// Affiche le formulaire d'ajout (produits)
$router->get('/produits/creer', [ProduitController::class, 'create']);

// Réceptionne + sauvegarde les données
$router->post('/produits/enregistrer', [ProduitController::class, 'store']);

// Routes pour la modification (produits)
$router->get('/produits/editer', [ProduitController::class, 'edit']);
$router->post('/produits/modifier', [ProduitController::class, 'update']);

// Route pour la suppression (produits)
$router->get('/produits/supprimer', [ProduitController::class, 'delete']);

// Routes login (connexion / déconnexion)
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/logout', [AuthController::class, 'logout']);

// Routes pour "Mon Profil"
$router->get('/profil', [ProfilController::class, 'index']);
$router->post('/profil/infos', [ProfilController::class, 'updateInfos']);
$router->post('/profil/mot-de-passe', [ProfilController::class, 'updatePassword']);

// Lance le moteur du Routeur en lui donnant l'URL demandée par le navigateur
// $_SERVER - Superglobale qui contient l'URL demandée par le navigateur
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


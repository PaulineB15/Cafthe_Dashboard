<?php
// App/Controllers/DashboardController.php

class DashboardController 
{
    public function index(): void 
    {
        // Récupère la connexion à la BDD (depuis le fichier Config)
        $config = require __DIR__ . '/../../Config/Database.php';
        $database = new Database($config);
        $pdo = $database->getConnection();

        // 2. On crée le Repository en lui passant la connexion PDO
        $employeRepo = new EmployeRepository($pdo);

        // 3. On lui demande de trouver tous les employés
        $employes = $employeRepo->findAll();

        // 4. On envoie la liste à la Vue
        View::render('Dashboard/Accueil', [
            'employes' => $employes
        ]);
    }
}
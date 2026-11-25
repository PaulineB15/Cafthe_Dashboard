<?php
// App/Controllers/DashboardController.php

class DashboardController 
{
    public function index(): void 
    {
        // 1. Récupère la connexion à la BDD
        $config = require __DIR__ . '/../../Config/Database.php';
        $database = new Database($config);
        $pdo = $database->getConnection();

        // 2. Calcul du Chiffre d'affaires total
        // Requête SQL
        $stmtCA = $pdo->query("SELECT SUM(MONTANT_TOTAL) as total FROM commande");
        $caTotal = $stmtCA->fetch()['total'] ?? 0;

        // 3. Commandes à traiter (Statut "En attente" ou "En cours")
        $stmtCmd = $pdo->query("SELECT COUNT(*) as nb FROM commande WHERE STATUT_COMMANDE IN ('En attente', 'En cours')");
        $nbCommandes = $stmtCmd->fetch()['nb'] ?? 0;

        // 4. Panier Moyen
        $stmtPanier = $pdo->query("SELECT AVG(MONTANT_TOTAL) as moyenne FROM commande");
        $panierMoyen = $stmtPanier->fetch()['moyenne'] ?? 0;

        // 5. Nombre total de clients
        $stmtClients = $pdo->query("SELECT COUNT(*) as nb FROM client");
        $nbClients = $stmtClients->fetch()['nb'] ?? 0;

        // 6. Alertes Stock (Produits actifs dont le stock est < 15)
        $stmtStock = $pdo->query("SELECT NOM_PRODUIT, STOCK FROM produit WHERE STOCK < 15 AND EST_ACTIF = 1 ORDER BY STOCK ASC");
        $alertesStock = $stmtStock->fetchAll();

        // 7. Les 5 dernières commandes (avec jointure pour avoir le nom du client)
        $stmtDernieres = $pdo->query("
            SELECT c.ID_COMMANDE, cl.NOM_CLIENT, cl.PRENOM_CLIENT, c.MONTANT_TOTAL, c.STATUT_COMMANDE 
            FROM commande c 
            JOIN client cl ON c.ID_CLIENT = cl.ID_CLIENT 
            ORDER BY c.ID_COMMANDE DESC 
            LIMIT 5
        ");
        $dernieresCommandes = $stmtDernieres->fetchAll();

        // 8. Top 5 produits les plus vendus
        $stmtTop = $pdo->query("
            SELECT p.NOM_PRODUIT, COALESCE(SUM(c.QUANTITE_COMMANDEE), 0) AS total_ventes
            FROM produit p
            JOIN contenir c ON p.ID_PRODUIT = c.ID_PRODUIT
            WHERE p.EST_ACTIF = 1
            GROUP BY p.ID_PRODUIT, p.NOM_PRODUIT
            ORDER BY total_ventes DESC
            LIMIT 5
        ");
        $topProduits = $stmtTop->fetchAll();

        // 9. On envoie toutes ces données dynamiques à la Vue
        View::render('Dashboard/Accueil', [
            'caTotal'            => $caTotal,
            'nbCommandes'        => $nbCommandes,
            'panierMoyen'        => $panierMoyen,
            'nbClients'          => $nbClients,
            'alertesStock'       => $alertesStock,
            'dernieresCommandes' => $dernieresCommandes,
            'topProduits'        => $topProduits
        ]);
    }
}
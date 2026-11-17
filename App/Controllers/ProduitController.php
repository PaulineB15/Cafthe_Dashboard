<?php

class ProduitController 
{
    // Affiche le tableau des stocks (pour le CRUD - Read les produits)
    public function index(): void 
    {
        // Connection à la BDD
        $config = require __DIR__ . '/../../Config/Database.php';
        $database = new Database($config);
        $pdo = $database->getConnection();

        // Appelle la classe "ProduitRepository" 
        $produitRepo = new ProduitRepository($pdo);

        // Récupération des filtres de recherche via l'URL (GET)
        $recherche = trim($_GET['recherche'] ?? '');
        $categorie = trim($_GET['categorie'] ?? '');

        // Récupère le catalogue complet des produits (avec filtres et tri DESC)
        $produits = $produitRepo->findAll($recherche, $categorie);

        // Envoie des données à la Vue "Produit/Stock"
        View::render('Produit/Stock', [
            'produits' => $produits,
            'recherche' => $recherche, // Transmis à la vue pour garder la valeur dans l'input
            'categorie' => $categorie
        ]);
    }

    // Affiche la page avec le formulaire HTML (pour le CRUD - ajouter un produit)
    public function create(): void
    {
        View::render('Produit/Creer');
    }

    // Réceptionne les données du formulaire (POST), sauvegarde + redirige
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nom = trim($_POST['nom'] ?? '');
            $categorie = trim($_POST['categorie'] ?? '');
            $type = trim($_POST['type'] ?? ''); 
            $typeVente = trim($_POST['type_vente'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $stock = $_POST['stock'] ?? '';
            $prixHt = $_POST['prix_ht'] ?? '';
            $tva = $_POST['tva'] ?? '';
            
            $images = trim($_POST['images'] ?? '');
            $images = $images === '' ? null : $images;

            if (empty($nom) || empty($categorie) || empty($type) || empty($typeVente) || empty($description) || $stock === '' || $prixHt === '' || $tva === '') {
                die("Erreur : Tous les champs sont obligatoires. Veuillez revenir en arrière.");
            }

            if (!is_numeric($prixHt) || !is_numeric($stock)) {
                die("Erreur : Le prix HT et le stock doivent être des valeurs numériques.");
            }

            $prixTtc = (float)$prixHt * (1 + ((float)$tva / 100));

            $donnees = [
                'nom'         => $nom,
                'categorie'   => $categorie,
                'type'        => $type, 
                'typeVente'   => $typeVente,
                'description' => $description,
                'stock'       => (int) $stock,
                'prixHt'      => (float) $prixHt,
                'tva'         => (float) $tva,
                'prixTtc'     => $prixTtc,
                'images'      => $images
            ];

            $config = require __DIR__ . '/../../Config/Database.php';
            $pdo = (new Database($config))->getConnection();
            $repo = new ProduitRepository($pdo);
            
            $repo->create($donnees);

            header('Location: /Cafthe_Dashboard/Public/produits');
            exit;
        }
    }

    // Afficher le formulaire de modification pré-rempli (pour le CRUD - Update un produit)
    public function edit(): void
    {
        if (!isset($_GET['id'])) {
            header('Location: /Cafthe_Dashboard/Public/produits');
            exit;
        }

        $config = require __DIR__ . '/../../Config/Database.php';
        $pdo = (new Database($config))->getConnection();
        $repo = new ProduitRepository($pdo);
        
        $produit = $repo->findById((int)$_GET['id']);
        
        if (!$produit) {
            die("Erreur : Ce produit n'existe pas.");
        }

        View::render('Produit/Editer', ['produit' => $produit]);
    }

    // Réceptionne + sauvegarde les données modifiées
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            
            $nom = trim($_POST['nom'] ?? '');
            $categorie = trim($_POST['categorie'] ?? '');
            $type = trim($_POST['type'] ?? ''); 
            $typeVente = trim($_POST['type_vente'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $stock = $_POST['stock'] ?? '';
            $prixHt = $_POST['prix_ht'] ?? '';
            $tva = $_POST['tva'] ?? '';
            
            $images = trim($_POST['images'] ?? '');
            $images = $images === '' ? null : $images;

            if (empty($nom) || empty($categorie) || empty($type) || empty($typeVente) || empty($description) || $stock === '' || $prixHt === '' || $tva === '') {
                die("Erreur : Tous les champs sont obligatoires.");
            }

            if (!is_numeric($prixHt) || !is_numeric($stock)) {
                die("Erreur : Le prix HT et le stock doivent être des valeurs numériques.");
            }

            $prixTtc = (float)$prixHt * (1 + ((float)$tva / 100));

            $donnees = [
                'nom'         => $nom,
                'categorie'   => $categorie,
                'type'        => $type, 
                'typeVente'   => $typeVente,
                'description' => $description,
                'stock'       => (int) $stock,
                'prixHt'      => (float) $prixHt,
                'tva'         => (float) $tva,
                'prixTtc'     => $prixTtc,
                'images'      => $images
            ];

            $config = require __DIR__ . '/../../Config/Database.php';
            $pdo = (new Database($config))->getConnection();
            $repo = new ProduitRepository($pdo);
            
            $repo->update($id, $donnees);

            header('Location: /Cafthe_Dashboard/Public/produits');
            exit;
        }
    }

    // Supprimer un produit
    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            
            $config = require __DIR__ . '/../../Config/Database.php';
            $pdo = (new Database($config))->getConnection();
            $repo = new ProduitRepository($pdo);
            
            $repo->delete($id);
        }

        header('Location: /Cafthe_Dashboard/Public/produits');
        exit;
    }
}
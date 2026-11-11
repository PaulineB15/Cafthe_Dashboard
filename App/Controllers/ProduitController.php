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

        // Récupère le catalogue complet des produits
        $produits = $produitRepo->findAll();

        // Envoie des données à la Vue "Produit/Stock"
        View::render('Produit/Stock', [
            'produits' => $produits
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
        // Vérifie que le formulaire a bien été envoyé (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Récupère les données BRUTES
            // La fonction trim() - enlève les espaces inutiles
            $nom = trim($_POST['nom'] ?? '');
            $categorie = trim($_POST['categorie'] ?? '');
            $typeVente = trim($_POST['type_vente'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $stock = $_POST['stock'] ?? '';
            $prixHt = $_POST['prix_ht'] ?? '';
            $tva = $_POST['tva'] ?? '';
            // L'image est facultative. Si c'est vide, on met strictement "null"
            $images = trim($_POST['images'] ?? '');
            $images = $images === '' ? null : $images;

            // VALIDATION SERVEUR (Comme demandé par ton formateur)
            // On vérifie que les champs obligatoires ne sont pas vides
            if (empty($nom) || empty($categorie) || empty($typeVente) || empty($description) || $stock === '' || $prixHt === '' || $tva === '') {
                // Pour l'instant, on fait une erreur simple. 
                // Plus tard, on pourra rediriger vers le formulaire avec un joli message d'erreur.
                die("Erreur : Tous les champs sont obligatoires. Veuillez revenir en arrière.");
            }

            // On vérifie que le prix et le stock sont bien des nombres
            if (!is_numeric($prix) || !is_numeric($stock)) {
                die("Erreur : Le prix et le stock doivent être des valeurs numériques.");
            }

            // Calcul automatique du TTC (Prix HT + (Prix HT * TVA / 100))
            $prixTtc = (float)$prixHt * (1 + ((float)$tva / 100));

            // Prépare nos données validées pour le Repository
            $donnees = [
                'nom'         => $nom,
                'categorie'   => $categorie,
                'typeVente'   => $typeVente,
                'description' => $description,
                'stock'       => (int) $stock,
                'prixHt'      => (float) $prixHt,
                'tva'         => (float) $tva,
                'prixTtc'     => $prixTtc,
                'images'      => $images
            ];

            // Connexion la BDD et appel à la classe "ProduitRepository"
            $config = require __DIR__ . '/../../Config/Database.php';
            $pdo = (new Database($config))->getConnection();
            $repo = new ProduitRepository($pdo);
            // Sauvegarde à la BDD
            // On utilise le nouvel outil qu'on a créé tout à l'heure !
            $repo->create($donnees);

            // Redirection après validation (évite les doublons si on rafraîchit la page)
            header('Location: /Cafthe_Dashboard/Public/produits');
            exit;
        }
    }



    // Afficher le formulaire de modification pré-rempli (pour le CRUD - Update un produit)
    public function edit(): void
    {
        // Vérifie qu'on a bien un ID dans l'URL (ex: ?id=5)
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
            $prix = $_POST['prix'] ?? '';
            $stock = $_POST['stock'] ?? '';

            if (empty($nom) || empty($categorie) || $prix === '' || $stock === '') {
                die("Erreur : Tous les champs sont obligatoires.");
            }

            $donnees = [
                'nom'       => $nom,
                'categorie' => $categorie,
                'prix'      => (float) $prix,
                'stock'     => (int) $stock
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
        // Vérifie qu'on a bien reçu un ID à supprimer
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            
            $config = require __DIR__ . '/../../Config/Database.php';
            $pdo = (new Database($config))->getConnection();
            $repo = new ProduitRepository($pdo);
            
            // On appelle notre nouvel outil de suppression
            $repo->delete($id);
        }

        // Redirige vers le tableau des stocks
        header('Location: /Cafthe_Dashboard/Public/produits');
        exit;
    }

}